<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWishlist extends Model
{
    protected $fillable = [
        'UserID',
        'ItemID',
    ];
    use HasFactory;
}
