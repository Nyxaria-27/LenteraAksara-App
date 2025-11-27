<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\AdminReplyForUser;
use App\Notifications\NewContactForAdmin;;

class ContactController extends Controller
{
    // Hitung jumlah contacts yang admin belum lihat (mis. admin inbox)
    public function adminUnreadCount()
    {
        // admin saja bisa lihat (opsional: cek role)
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            return response()->json(['count' => 0]);
        }

        $count = Contact::where('admin_seen', false)->count();
        return response()->json(['count' => $count]);
    }



    // // Cek apakah user punya balasan yang belum dilihat
    public function userHasReply()
    {
        $user = Auth::user();
        if (!$user) return response()->json(['has_reply' => false]);

        // contact milik user dengan status replied dan user_seen = false
        $exists = Contact::where('user_id', $user->id)
            ->where('status', 'replied')
            ->where('user_seen', false)
            ->exists();

        return response()->json(['has_reply' => $exists]);
    }

    // // Tandai balasan sudah dilihat user (dipanggil saat user buka halaman contact / klik notif)
    public function userMarkSeen($id)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['ok' => false], 403);

        $contact = Contact::where('id', $id)->where('user_id', $user->id)->first();
        if ($contact) {
            $contact->update(['user_seen' => true]);
        }

        return response()->json(['ok' => true]);
    }


    // Ketika user membuka halaman contact -> tandai user_seen true dan read notif user
    public function index()
    {
        $contact = Contact::where('user_id', Auth::id())->first();

        if ($contact) {
            // tandai contact sudah dilihat user
            $contact->update(['user_seen' => true]);

            // dan tandai notifikasi terkait untuk user sebagai read
            $user = Auth::user();
            $user->unreadNotifications
                ->where(fn($n) => isset($n->data['contact_id']) && $n->data['contact_id'] == $contact->id)
                ->each->markAsRead();
        }

        return view('user.contact.index', compact('contact'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::where('user_id', Auth::id())->first();

        if ($contact) {
            $contact->update([
                'subject' => $request->subject,
                'message' => $contact->message . "\n\n--- Update " . now()->format('d M Y H:i') . " ---\n" . $request->message,
                'status' => 'open',
                'admin_seen' => false,
                // jangan ubah user_seen
            ]);
        } else {
            $contact = Contact::create([
                'user_id' => Auth::id(),
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'open',
                'admin_seen' => false,
                'user_seen' => true,
            ]);
        }

        // Notifikasi ke semua admin (pastikan $contact bukan null)
        // setelah create/update contact berada di $contact
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewContactForAdmin($contact));
        }


        return redirect()->route('user.contact.index')->with('success', 'Pesan berhasil dikirim!');
    }


    public function adminIndex()
    {
        $q = request('q');
        $status = request('status');
        $seen = request('seen');

        $contactsQuery = Contact::with('user')->latest('updated_at');

        // Search by user name, email, subject, or message
        if ($q) {
            $contactsQuery->where(function($query) use ($q) {
                $query->where('subject', 'like', "%{$q}%")
                      ->orWhere('message', 'like', "%{$q}%")
                      ->orWhereHas('user', function($userQuery) use ($q) {
                          $userQuery->where('name', 'like', "%{$q}%")
                                    ->orWhere('email', 'like', "%{$q}%");
                      });
            });
        }

        // Filter by status
        if ($status && in_array($status, ['open', 'replied', 'closed'])) {
            $contactsQuery->where('status', $status);
        }

        // Filter by seen status
        if ($seen === 'unread') {
            $contactsQuery->where('admin_seen', false);
        } elseif ($seen === 'read') {
            $contactsQuery->where('admin_seen', true);
        }

        $contacts = $contactsQuery->paginate(10)->withQueryString();
        
        return view('admin.contacts.index', compact('contacts', 'q', 'status', 'seen'));
    }

    public function adminShow($id)
    {
        $contact = Contact::findOrFail($id);

        // tandai sudah dilihat admin pada contact
        $contact->update(['admin_seen' => true]);

        // tandai juga semua notifikasi unread milik admin terkait contact ini menjadi read
        $admin = Auth::user();
        if ($admin && $admin->role === 'admin') {
            $admin->unreadNotifications
                ->where(fn($n) => isset($n->data['contact_id']) && $n->data['contact_id'] == $contact->id)
                ->each->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    // Optional route: admin menandai sebagai 'seen' via ajax/button
    public function adminMarkSeen($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['ok' => false], 403);
        }

        $contact = Contact::find($id);
        if ($contact) {
            $contact->update(['admin_seen' => true]);
            // mark related admin notifications as read
            $user->unreadNotifications
                ->where(fn($n) => isset($n->data['contact_id']) && $n->data['contact_id'] == $contact->id)
                ->each->markAsRead();
        }

        return response()->json(['ok' => true]);
    }

    // Optional route: tandai replied (button) tanpa mengirim reply text
    public function adminMarkReplied($id)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 'replied', 'user_seen' => false]);

        // notify user (if you want)
        if ($contact->user) {
            $contact->user->notify(new AdminReplyForUser($contact));
        }

        return redirect()->route('admin.contacts.show', $id)->with('success', 'Marked as replied.');
    }






    public function adminReply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update([
            'admin_reply' => $contact->admin_reply . "\n\n--- Reply " . now()->format('d M Y H:i') . " ---\n" . $request->admin_reply,
            'status' => 'replied',
            'user_seen' => false,   // beri tahu user ada balasan baru
        ]);


        // Kirim notifikasi ke user pemilik contact
        if ($contact->user) {
            $contact->user->notify(new AdminReplyForUser($contact));
        }

        return redirect()->route('admin.contacts.show', $id)->with('success', 'Balasan terkirim!');
    }
}
