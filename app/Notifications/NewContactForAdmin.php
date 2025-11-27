<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactForAdmin extends Notification
{
    use Queueable;

    protected $contact;

    /**
     * Create a new notification instance.
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contact_id' => $this->contact->id,
            'user_name' => $this->contact->user->name ?? 'Unknown',
            'user_email' => $this->contact->user->email ?? '',
            'subject' => $this->contact->subject,
            'message' => \Illuminate\Support\Str::limit($this->contact->message, 100),
            'url' => route('admin.contacts.show', $this->contact->id),
            'title' => 'Pesan Baru dari Pengguna',
        ];
    }
}
