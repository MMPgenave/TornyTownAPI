<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocials extends Model
{
    protected $fillable = [
        'UserID',
        'Name',
        'Link',
    ];
    use HasFactory;
}
