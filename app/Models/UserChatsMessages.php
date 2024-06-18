<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChatsMessages extends Model
{
    protected $fillable = [
        'SenderID',
        'ReceiverID',
        'ChatID',
        'Type',
        'Message',
        'Image',
        'Status',
    ];
    use HasFactory;

    public function Chat()
    {
        return $this->belongsTo(UserChats::class , 'ChatID' , 'id');
    }
}
