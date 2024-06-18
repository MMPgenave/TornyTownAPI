<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserItems extends Model
{
    protected $fillable = [
        'UserID',
        'ItemID',
        'Buy_at',
    ];
    use HasFactory;
}
