<?php

namespace App\Http\Controllers;

use App\Class\Response;
use App\Models\Airdrops;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','refresh','logout' , 'CheckUsername']]);
    }


    public function CheckUsername(Request $request)
    {
        $request->validate([
            'UserName' => 'required|string'
        ]);

        $UserCount = User::where('UserName' , $request->UserName)->count();
        if ($UserCount > 0){
            return Response::Success('Username exists' , 403 ,['Status' => false] );
        }else{
            return Response::Success('Username available' , 200 ,['Status' => true] );
        }
    }


    public function register(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'UserName' => 'required|string|unique:users',
            'ReferralID' => 'nullable|string|exists:users,TTID'
        ]);


        try {
            $User = User::create([
                'TTID' => 'TT' . rand(1000000 , 1000000000000000000),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'Avatar' => '/images/avatar.png',
                'UserName' => $request->UserName,
            ]);

            if ($request->ReferralID){
                $ReferralUser = User::where('TTID' , $request->ReferralID)->first();
                $User->ReferralUser = $ReferralUser->id;
                $User->save();
            }
            Airdrops::create([
                'UserID' => $User->id,
                'Amount' => 3000,
            ]);
            $User->update([
                'Coin' => 3000
            ]);

            $token = Auth::guard('api')->login($User);

            $Data = [
                'User' => $User,
                'Token' => $token
            ];
            return Response::Success('User created successfully' , 201 ,$Data );
        }catch (\Exception $error){
            return Response::Failed($error->getMessage() , $error->getCode()  );
        }


    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string',
        ]);

        try {
            $credentials = $request->only('email', 'password');
            $token = Auth::guard('api')->attempt($credentials);
            if (!$token) {
                return response()->json([
                    'Status' => 'error',
                    'Message' => 'Unauthorized',
                ], 401);
            }

            $user = Auth::guard('api')->user();
            $Data = [
                'User' => $user,
                'Token' => $token
            ];
            return Response::Success('Successfully logged in' , 200 ,$Data );
        }catch(\Exception $error){
            return Response::Failed($error->getMessage() , $error->getCode()  );
        }


    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return Response::Success('Successfully logged out' , 200 );
    }


    public function refresh()
    {
        $Data = [
            'User' => Auth::guard('api')->user(),
            'Token' => Auth::guard('api')->refresh()
        ];
        return Response::Success('refresh successfully' , 200 ,$Data );
    }
}
