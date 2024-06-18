<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
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
        'Hash',
        'Status',
    ];
    use HasFactory;
}
