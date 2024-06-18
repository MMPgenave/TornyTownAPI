<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsCategory extends Model
{
    protected $fillable = [
        'Name'
    ];
    use HasFactory;
}
