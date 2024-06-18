<?php

namespace App\Http\Controllers;

use App\Class\Response;
use App\Models\User;
use App\Models\UserChats;
use App\Models\UserChatsMessages;
use App\Models\UserFriends;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserChatsController extends Controller
{
    protected \Illuminate\Contracts\Auth\Authenticatable|null|User $User;
    public function __construct()
    {
        $this->User = Auth::guard('api')->user();
    }
    public function List(Request $request)
    {
        try {
            $User = $this->User;
            $Chats =  UserChatsMessages::where('SenderID', $this->User->id)
                ->orWhere('ReceiverID', $this->User->id)
                ->groupBy('ChatID')
                ->get(['ChatID' ])
            ;

            $Data = [
              'Chats' => $Chats
            ];


            return Response::Success('Chat List Loaded' , 200  ,$Data);
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }
    public function Get($ChatID)
    {
        try {
            $User = $this->User;
            $Chats =  UserChatsMessages::where('ChatID' , $ChatID)->latest()->get();

            $Data = [
              'Chats' => $Chats
            ];


            return Response::Success('Chats Loaded' , 200  ,$Data);
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }


    public function Send(Request $request)
    {
        try {
            $User = $this->User;
            $request->validate([
                'ReceiverID' => 'required_unless:ChatID,null|string|exists:users,id',
                'ChatID' => 'nullable|int|exists:user_chats,id',
                'Type' => ['required' , 'string' , Rule::in(['Text' , 'Image'])],
                'Message' => 'nullable|string',
            ]);
            $Receiver = User::find($request->ReceiverID);
            if (!$Receiver){
                return Response::Failed('Cant find receiver user' , 422  );
            }
            $collection = $this->IsTherePreviousChat($Receiver->id, $User->id);

            if ($collection == false) {
                $chat = UserChats::create([
                    'UserID' => $User->id
                ]);
            }
            if ($request->Type == 'Text'){
                $message = UserChatsMessages::create([
                    'SenderID' => $User->id,
                    'ReceiverID'   => $Receiver->id,
                    'ChatID'   => $collection == false ?  $chat->id : $collection[0]->ChatID,
                    'Type'   => 'Text' ,
                    'Status'   => 'New' ,
                    'Message'   => $request->Message ,
                ]);
            }

            $Data = [
                'Message' => $message
            ];


            return Response::Success('Message sent successfully' , 200 , $Data  );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }


    }


    public function Read(Request $request)
    {
        $request->validate([
            'ChatID' => ['required' , 'int' , 'exists:user_chats_messages']
        ]);
        try {
            $User = $this->User;
            $Chats =  UserChatsMessages::where('ReceiverID', $this->User->id)
                ->where('ChatID' , $request->ChatID)
                ->update([
                    'Status' => 'Read'
                    ])
            ;




            return Response::Success('Chats marked as Read' , 200 );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }


    public function NewMessageCount($ChatID)
    {
        try {
            $User = $this->User;
            $Chats =  UserChatsMessages::where('ReceiverID', $this->User->id)
                ->where('ChatID' , $ChatID)
                ->where('Status' , 'New')
                ->count()
            ;

            $Data = [
                'Count' => $Chats
            ];



            return Response::Success('new message count' , 200 ,$Data);
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }


    public function IsTherePreviousChat($OtherUserId, $user_id)
    {
        $collection = UserChatsMessages::whereHas('Chat', function ($q) use ($OtherUserId, $user_id) {
            $q->where('SenderID', $OtherUserId)
                ->where('ReceiverID', $user_id);
        })->orWhere(function ($q) use ($OtherUserId, $user_id) {
            $q->where('SenderID', $user_id)
                ->where('ReceiverID', $OtherUserId);
        })->get();
        if (count($collection) > 0) {
            return $collection;
        }
        return false;
    }
}
