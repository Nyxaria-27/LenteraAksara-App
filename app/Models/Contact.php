<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'admin_reply',
        'status',
        'admin_seen',
        'user_seen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
