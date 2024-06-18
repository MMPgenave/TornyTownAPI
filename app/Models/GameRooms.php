<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRooms extends Model
{
    protected $fillable = [
        'RoomID',
        'Players',
        'GameName',
        'Bet',
        'Type',
        '',
    ];
    use HasFactory;
}
