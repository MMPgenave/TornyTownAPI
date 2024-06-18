<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoins extends Model
{
    protected $fillable = [
        'UserID',
        'Action', // Add , Remove
        'Amount',
        'Because',
    ];
    use HasFactory;

    public static function WinAGame(int $UserID , $Amount)
    {
        self::create([
            'UserID' => $UserID,
            'Action' => 'Add',
            'Amount' => $Amount,
            'Because' => 'Win a game',
        ]);
    }
    public static function LoseAGame(int $UserID , $Amount)
    {
        self::create([
            'UserID' => $UserID,
            'Action' => 'Remove',
            'Amount' => $Amount,
            'Because' => 'Losses a game',
        ]);
    }
}
