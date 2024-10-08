<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = [
        'PaymentID',
        'UserID',
        'Type',
        'ItemID',
        'Amount',
        'FinalAmount',
        'WalletAddress',
        'Hash',
        'Status',
    ];
    use HasFactory;
}
