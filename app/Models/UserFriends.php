<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFriends extends Model
{
    protected $fillable = [
        'UserID',
        'FriendID',
        'Status',
    ];
    use HasFactory;


    public function User()
    {
        return $this->belongsTo(User::class , 'UserID' , 'id');
    }
    public function Friend()
    {
        return $this->belongsTo(User::class , 'FriendID' , 'id');
    }
}
