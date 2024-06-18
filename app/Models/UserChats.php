<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChats extends Model
{
    protected $fillable = [
        'UserID',
    ];
    use HasFactory;

    public function User()
    {
        return $this->belongsToMany(User::class , UserChats::class , 'UserID' , 'id');
    }

    public function Messages()
    {
        return $this->hasMany(UserChatsMessages::class , 'ChatID' , 'id');
    }
}
