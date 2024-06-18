<?php

namespace App\Http\Controllers;

use App\Class\Response;
use App\Models\User;
use App\Models\UserFriends;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFriendsController extends Controller
{
    protected \Illuminate\Contracts\Auth\Authenticatable|null|User $User;
    public function __construct()
    {
        $this->User = Auth::guard('api')->user();
    }

    public function Add(Request $request)
    {
        $request->validate([
            'UserID' => ['required' , 'integer' , 'exists:users,id']
        ]);
        try {
            $User = $this->User;
            $Friends = User::find($request->UserID);
            if ($User->friendsOfMine()->where('FriendID' , $request->UserID)->count() > 0){
                return Response::Success('already friended with this user' , 200  );
            }
            $Status = $Friends->Profile == 'Public' ? 'Accepted' : 'Pending';
            UserFriends::create([
                'UserID' => $User->id,
                'FriendID' => $Friends->id,
                'Status' => $Status,
            ]);
            return Response::Success('Friend Added Successfully' , 200  );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }

    }
    public function Remove(Request $request)
    {
        $request->validate([
            'UserID' => ['required' , 'integer' , 'exists:users,id']
        ]);
        try {
            $User = $this->User;
            $Friends = User::find($request->UserID);
            if ($User->friendsOfMine()->where('FriendID' , $request->UserID)->count() == 0){
                return Response::Success('youre not friend with this user' , 200  );
            }

            $UF = UserFriends::where([
                ['UserID' , $User->id],
                ['FriendID' , $Friends->id]
            ])->first();
            $UF->delete();
            return Response::Success('Friend Removed Successfully' , 200  );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }
    public function FriendsOfList(Request $request)
    {
        try {
            $User = $this->User;
            $Data = [
                $User->friendsOfMine()->with('Friend:id,TTID,UserName,FirstName,LastName,Bio,total_game_played,total_game_wins,total_game_loses,Type,Avatar,Profile')->get()
            ];
            return Response::Success('Friends of mine list' , 200 , $Data  );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }
    public function FriendsList(Request $request)
    {
        try {
            $User = $this->User;
            $Data = [
                $User->friendOf()->with('User:id,TTID,UserName,FirstName,LastName,Bio,total_game_played,total_game_wins,total_game_loses,Type,Avatar,Profile')->get()
            ];
            return Response::Success('Friend list' , 200 , $Data  );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }

    public function FriendsCount($Username)
    {
        try {
            $User = User::where('UserName' , $Username)->first();
            $Data = [
                'Friends' => $User->friendOf()->count(),
                'FriendsOf' => $User->friendsOfMine()->count(),
            ];
            return Response::Success('Friend list' , 200 , $Data  );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }
}
