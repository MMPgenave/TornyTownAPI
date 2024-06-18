<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGames extends Model
{
    protected $fillable = [
        'UserID',
        'Name',
        'Level',
        'Rank',
        'XP',
        'TotalXP',
        'total_game_played',
        'total_game_wins',
        'total_game_loses',
        '',
        '',
        '',
    ];
    use HasFactory;

    public function User()
    {
        return $this->belongsTo(User::class , 'UserID' , 'id');
    }

    public static function WinAGame(User $user , string $GameName)
    {
        $UserGame = $user->Games()->firstOrNew([
            ['UserID' ,  $user->id],
            ['Name' , $GameName]
        ]);
        $UserGame->Name = $GameName;
        if ($UserGame->Level == null){
            $UserGame->Level = 1;
            $UserGame->Rank = 1;
            $UserGame->XP += 100;
        }else{
            if ($UserGame->XP == 1000){
                $UserGame->Level += 1;
                $UserGame->XP = 0;
                $UserGame->TotalXP += 1000;
            }else{
                $UserGame->XP += 100;
            }
        }
        $UserGame->save();
    }
}
