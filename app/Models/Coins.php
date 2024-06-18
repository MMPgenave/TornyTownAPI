<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coins extends Model
{
    protected $fillable = [
        'Name',
        'Image',
        'Coins',
        'Price',
    ];
    use HasFactory;
}
