<?php

namespace App\Http\Controllers;

use App\Class\Response;
use App\Models\GameHistory;
use App\Models\GameRooms;
use App\Models\User;
use App\Models\UserCoins;
use App\Models\UserGames;
use Illuminate\Http\Request;

class GameRoomsController extends Controller
{
    public function Get(string $RoomID)
    {
        if (GameRooms::where('RoomID' , $RoomID)->count() == 0){
            $errors[] = [
                'filed' => 'RoomID',
                'message' => 'Room does not exist',
            ];
            return Response::Error( 422,$errors  );
        }
        try {
            $Room = GameRooms::where('RoomID' , $RoomID)->first();
            $Data = [
                'Room' => $Room,
            ];
            return Response::Success('Room found successfully' , 201 ,$Data );
        }catch (\Exception $error){
            return Response::Failed($error->getMessage() , $error->getCode()  );
        }
    }
    public function Create(Request $request)
    {
        $request->validate([
            'Players' => 'required|json',
            'GameName' => 'required|string',
            'Bet' => 'required|integer',
        ]);

        try {
            $PlayersID = json_decode($request->Players);
            $Player1 = User::find($PlayersID[0]);
            $Player2 = User::find($PlayersID[1]);
            if ($Player1 && $Player2){
                $RoomID = 'TTGR' . $this->GetRandNumber();
                $Room = GameRooms::create([
                    'RoomID' => $RoomID,
                    'Players' => json_encode([$Player1->id , $Player2->id]),
                    'GameName' => $request->GameName,
                    'Bet' => $request->Bet,
                    'Type' => 'Open',
                ]);
                $Data = [
                    'Room' => $Room,
                ];
                return Response::Success('Room created successfully' , 201 ,$Data );
            }else{
                return Response::Failed('Cant find players' , 422  );
            }



        }catch (\Exception $error){
            return Response::Failed($error->getMessage() , $error->getCode()  );
        }
    }
    public function Close(Request $request)
    {
        $request->validate([
            'RoomID' => 'required|string|exists:game_rooms',
            'Winner' => 'required|int|exists:users,id',
            'Loser' => 'required|int|exists:users,id'
        ]);
        try {
            $Room = GameRooms::where('RoomID' , $request->RoomID)->first();
            $Players = json_decode($Room->Players , true);


            if (count(array_intersect($Players , [$request->Winner , $request->Loser] )) < 2){
                return Response::Failed('Players not match with room id ' , 401  );
            }

            $Room->update([
                'Type' => 'Closed'
            ]);

            $History = GameHistory::create([
                'RoomID' => $Room->id,
                'Players' => $Room->Players,
                'GameName' => $Room->GameName,
                'Bet' => $Room->Bet,
                'Winner' => $request->Winner,
                'Loser' => $request->Loser,
            ]);

            $Winner = User::find($request->Winner);
            $Loser = User::find($request->Loser);

            $Winner->Coin += $Room->Bet;
            $Winner->total_game_played += 1;
            $Winner->total_game_wins += 1;
            $Winner->XP += 100;
            $Winner->save();

            UserGames::WinAGame($Winner , $Room->GameName);
            UserCoins::WinAGame($Winner->id , $Room->Bet);

            $Loser->Coin -= $Room->Bet;
            $Loser->total_game_played += 1;
            $Loser->total_game_loses += 1;
            $Loser->save();
            UserCoins::LoseAGame($Loser->id , $Room->Bet);


            $Data = [
                'History' => $History,
            ];
            return Response::Success('Room closed successfully' , 200 ,$Data );
        }catch (\Exception $error){
            return Response::Failed($error->getMessage() , $error->getCode()  );
        }
    }
}
