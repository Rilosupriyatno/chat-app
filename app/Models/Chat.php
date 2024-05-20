<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'sender_name',
        'recipient_id',
        'recipient_name',
        'message',
        'is_send',
        'is_seen',
        'is_read',
    ];
}
