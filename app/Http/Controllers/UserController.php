<?php

namespace App\Http\Controllers;

use App\Class\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    protected \Illuminate\Contracts\Auth\Authenticatable|null|User $User;
    public function __construct()
    {
        $this->User = Auth::guard('api')->user();
    }

    public function profile()
    {
        $Data = [
            'User' => Auth::guard('api')->user(),
        ];
        return Response::Success('User Found' , 200 ,$Data );
    }

    public function UpdateDetails(Request $request)
    {
        $request->validate([
            'FirstName' => 'nullable|string',
            'LastName' => 'nullable|string',
            'Bio' => 'nullable|string',
            'Gender' => ['nullable' , Rule::in(['Male' , 'Female' , 'Other'])],
            'Birthday' => 'nullable|date',
            'Country' => 'nullable|string',
            'City' => 'nullable|string',
            'Profile' => ['nullable' , Rule::in(['Public' , 'Private'])],
        ]);


        try {
            $this->User->update([
                'FirstName' => $request->FirstName ? $request->FirstName : $this->User->FirstName,
                'LastName' => $request->LastName ? $request->LastName : $this->User->LastName,
                'Bio' => $request->Bio ? $request->Bio : $this->User->Bio,
                'Gender' => $request->Gender ? $request->Gender : $this->User->Gender,
                'Birthday' => $request->Birthday ? $request->Birthday : $this->User->Birthday,
                'Country' => $request->Country ? $request->Country : $this->User->Country,
                'City' => $request->City ? $request->City : $this->User->City,
                'Profile' => $request->Profile ? $request->Profile : $this->User->Profile,
            ]);

            $Data = [
                'User' => Auth::guard('api')->user(),
            ];
            return Response::Success('User Updated' , 200 ,$Data );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }

    public function UpdatePassword(Request $request)
    {
        $request->validate([
            'CurrentPassword' => 'required|string',
            'NewPassword' => 'required|string',
        ]);

        try {
            $User = $this->User;
            if (Hash::check($request->CurrentPassword , $User->password) ){
                $User->password == Hash::make($request->NewPassword);
                Auth::guard('api')->logout();
                return Response::Success('Password changed successfully' , 200 );
            }else{
                return Response::Failed('Current password does not match' , 401  );
            }
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }

    }

    public function UpdateUserName(Request $request)
    {
        $request->validate([
            'UserName' => 'required|string|unique:users',
        ]);

        try {
            $User = $this->User;
            $User->UserName = $request->UserName;
            $User->save();
            $Data = [
                'User' => Auth::guard('api')->user(),
            ];
            return Response::Success('Username changed successfully' , 200 ,$Data );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }

    }

    public function UpdateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
        ]);


        try {
            $User = $this->User;
            $User->email = $request->email;
            $User->email_verified_at = null;
            $User->save();
//            $User->sendEmailVerificationNotification();
            $Data = [
                'User' => Auth::guard('api')->user(),
            ];
            return Response::Success('email changed successfully' , 200 ,$Data );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }

    // change profile picture by MMP 


    public function UpdateAvatar(Request $request)
    {
        $request->validate([
            'Avatar' => 'required|string',
        ]);


        try {
            $User = $this->User;
            $User->Avatar = $request->Avatar;
            $User->save();
            $Data = [
                'User' => Auth::guard('api')->user(),
            ];
            return Response::Success('Avatar changed successfully' , 200 ,$Data );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }

    // end of changing profile picture

    public function CoinHistory()
    {
        $Data = [
            'History' => Auth::guard('api')->user()->UserCoins,
        ];
        return Response::Success('User Coin History Found' , 200 ,$Data );
    }

    public function search(Request $request)
    {
        $request->validate([
            'UserName' => 'required|string'
        ]);
        try {
            $User = User::where('UserName' , 'LIKE' , '%'.$request->UserName.'%')->get();
            $Data = [
                'Users' => $User,
            ];
            return Response::Success('Users Found' , 200 ,$Data );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }

    }

    public function details(Request $request)
    {
        $request->validate([
            'UserName' => 'required|string|exists:users'
        ]);
        try {
            $User = User::where('UserName' , $request->UserName)->first();
            $Data = [
                'User' => $User,
            ];
            return Response::Success('User Found' , 200 ,$Data );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }

    public function detailsbyid(int $id)
    {
        try {
            $User = User::find($id);
            $Data = [
                'User' => $User,
            ];
            return Response::Success('User Found' , 200 ,$Data );
        }catch(\Exception $e){
            return Response::Failed($e->getMessage() , $e->getCode()  );
        }
    }


}
