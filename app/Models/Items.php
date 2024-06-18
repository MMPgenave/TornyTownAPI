<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = [
        'Name',
        'Description',
        'Type',
        'Category',
        'Price',
        'Count',
        'Image',
        'Status',
        'SpecialOffer',
        '',
    ];
    use HasFactory;
}
