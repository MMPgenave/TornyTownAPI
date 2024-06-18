<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject , MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'TTID',
        'FirstName',
        'LastName',
        'UserName',
        'email',
        'password',
        'email_verified_at',
        'password',
        'Bio',
        'total_game_played',
        'total_game_wins',
        'total_game_loses',
        'Type',
        'Coin',
        'Gem',
        'XP',
        'RankXP',
        'Level',
        'Gender',
        'Avatar',
        'Birthday',
        'Country',
        'City',
        'Header',
        'Frame',
        'ReferralUser',
        'Profile',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email'=>$this->email,
            'name'=>$this->name
        ];
    }

    public function UserCoins()
    {
        return $this->hasMany(UserCoins::class , 'UserID' , 'id' );
    }


    public function Games()
    {
        return $this->hasMany(UserGames::class , 'UserID' , 'id' );
    }

    function friendsOfMine()
    {
        return $this->hasMany(UserFriends::class, 'UserID', 'id');
//        return $this->hasMany(UserFriends::class, 'UserID', 'id')->join('users', 'users.id', '=', 'user_friends.FriendID')
//            ->select('user_friends.*', 'users.TTID' , 'users.UserName' , 'users.FirstName' , 'users.LastName' , 'users.Bio'  , 'users.total_game_played'  , 'users.total_game_wins'  , 'users.total_game_loses' , 'users.Type' , 'users.Avatar' , 'users.Profile' );
    }

    function friendOf()
    {
        return $this->hasMany(UserFriends::class, 'FriendID', 'id');

//        return $this->hasMany(UserFriends::class, 'FriendID', 'id')->select(['UserID' ,'FriendID','Status']);

    }

    public function Chats()
    {
        return $this->belongsTo(UserChats::class , 'id' , 'UserID');
    }






}
