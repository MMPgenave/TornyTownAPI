<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airdrops extends Model
{
    protected $fillable = [
        'UserID',
        'Amount',
    ];
    use HasFactory;
}
