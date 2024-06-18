<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        'DepositID',
        'UserID',
        'Type',
        'Gateway',
        'Blockchain',
        'Currency',
        'CurrencyAmount',
        'CurrencyFinalAmount',
        'Amount',
        'FinalAmount',
        'WalletAddress',
        'Hash',
        'Status',
    ];

    use HasFactory;
}
