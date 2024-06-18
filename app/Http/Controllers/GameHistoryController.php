<?php

namespace App\Http\Controllers;

use App\Class\Response;
use App\Models\GameHistory;
use App\Models\GameRooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameHistoryController extends Controller
{
    public function Get()
    {
        try {
            $User = Auth::guard('api')->user();

            $Historys = GameHistory::where('Winner' ,$User->id )->orWhere('Loser' , $User->id)->get();
            $Data = [
                'Rooms' => $Historys,
            ];
            return Response::Success('Room found successfully' , 201 ,$Data );
        }catch (\Exception $error){
            return Response::Failed($error->getMessage() , $error->getCode()  );
        }
    }


}
