<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImages extends Model
{
    protected $fillable = [
        'UserID',
        'ImageAddress',
        '',
    ];
    use HasFactory;
}
