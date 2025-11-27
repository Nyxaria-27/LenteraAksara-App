<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OrderController extends Controller
{
    /**
     * Show all orders of logged-in user with optional status filter
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        
        $query = Order::where('user_id', Auth::id())
            ->with('items.book');
        
        // Filter by status if provided
        if ($status && in_array($status, ['pending', 'processing', 'shipped', 'completed'])) {
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('user.orders.index', compact('orders', 'status'));
    }

    /**
     * Show detail of specific order
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.book')
            ->findOrFail($id);

        return view('user.orders.show', compact('order'));
    }

     public function adminIndex(Request $request)
    {
        $q = $request->query('q');        // search keyword
        $userId = $request->query('user'); // selected user id (optional)
        $status = $request->query('status'); // filter by status

        // 1) Users that HAVE orders (with count + sum), optional search by name/email
        $usersQuery = User::has('orders')
                          ->withCount('orders')
                          ->withSum('orders', 'total_price');

        if ($q) {
            $usersQuery->where(function($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            });
        }

        // paginate users
        $users = $usersQuery->orderBy('orders_count', 'desc')->paginate(15)->withQueryString();

        // 2) Orders list: either for selected user OR global search by order id / book title / user
        $ordersQuery = Order::with('user', 'items.book');

        if ($userId) {
            $ordersQuery->where('user_id', $userId);
        }
        
        // Filter by status
        if ($status && in_array($status, ['pending', 'processing', 'shipped', 'completed'])) {
            $ordersQuery->where('status', $status);
        }

        if ($q) {
            $ordersQuery->where(function($w) use ($q) {
                $w->where('id', $q) // search by order id exact/partial
                  ->orWhereHas('user', function($u) use ($q) {
                      $u->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                  })
                  ->orWhereHas('items.book', function($b) use ($q) {
                      $b->where('title', 'like', "%{$q}%");
                  });
            });
        }

        $orders = $ordersQuery->latest()->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('users','orders','q','userId','status'));
    }

    // Detail user: tampilin orders milik user (paginated)
    public function adminUserShow(User $user)
    {
        // Ambil semua orders (yang tidak dihapus) milik user, eager load items & book
        $orders = Order::with('items.book')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('admin.orders.detailUserTransactions', compact('user', 'orders'));
    }


    public function adminShow($id)
    {
        $order = Order::with('user', 'items.book')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function adminUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed',
            'shipping_notes' => 'nullable|string|max:1000'
        ], [
            'status.required' => 'Status pesanan wajib dipilih',
            'status.in' => 'Status pesanan tidak valid',
            'shipping_notes.max' => 'Catatan pengiriman maksimal 1000 karakter'
        ]);

        $order = Order::findOrFail($id);

        // Define status hierarchy (tidak boleh mundur)
        $statusHierarchy = [
            'pending' => 1,
            'processing' => 2,
            'shipped' => 3,
            'completed' => 4
        ];

        $currentStatusLevel = $statusHierarchy[$order->status] ?? 0;
        $newStatusLevel = $statusHierarchy[$request->status] ?? 0;

        // Cegah perubahan status jika sudah completed
        if ($order->status === 'completed') {
            return redirect()->back()
                ->with('error', 'Pesanan sudah selesai dan tidak dapat diubah lagi.');
        }

        // Cegah mundur ke status sebelumnya
        if ($newStatusLevel < $currentStatusLevel) {
            $statusLabels = [
                'pending' => 'Menunggu Pembayaran',
                'processing' => 'Diproses',
                'shipped' => 'Dikirim',
                'completed' => 'Selesai'
            ];
            
            return redirect()->back()
                ->with('error', "Status tidak dapat diubah mundur dari '{$statusLabels[$order->status]}' ke '{$statusLabels[$request->status]}'.");
        }

        // Simpan status lama sebelum di-update
        $oldStatus = $order->status;

        // Kurangi stock saat status berubah dari 'pending' menjadi 'processing', 'shipped', atau 'completed'
        if ($oldStatus === 'pending' && in_array($request->status, ['processing', 'shipped', 'completed'])) {
            foreach ($order->items as $item) {
                $book = $item->book;
                if ($book->stock >= $item->quantity) {
                    $book->decrement('stock', $item->quantity);
                } else {
                    return redirect()->back()
                        ->with('error', "Stok buku '{$book->title}' tidak mencukupi! Stok tersedia: {$book->stock}, diperlukan: {$item->quantity}");
                }
            }
        }

        // Update order setelah stock dikurangi
        $updateData = ['status' => $request->status];
        
        // Only update shipping_notes if provided
        if ($request->filled('shipping_notes')) {
            $updateData['shipping_notes'] = $request->shipping_notes;
        }

        $order->update($updateData);

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
