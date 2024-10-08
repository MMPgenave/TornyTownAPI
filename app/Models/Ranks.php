<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranks extends Model
{
    protected $fillable = [
        'Name',
        'Xp',
        'Rewards',
        'Icon',
    ];
    use HasFactory;
}
