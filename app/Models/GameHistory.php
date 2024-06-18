<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{
    protected $fillable = [
        'RoomID',
        'Players',
        'GameName',
        'Bet',
        'Winner',
        'Loser',
    ];
    use HasFactory;


    public function Winner()
    {
        return $this->hasOne(User::class , 'id' , 'Winner');
    }
    public function Loser()
    {
        return $this->hasOne(User::class , 'id' , 'Loser');
    }


}
