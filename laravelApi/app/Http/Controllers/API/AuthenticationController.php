<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class AuthenticationController extends Controller
{
    //POST [name, email, passworđ]
    public function register(Request $request){
        //Validation
        $request->validate([
            "name" => "required|string",
            "email" => "required|string|email|unique:users",
            "password" => "required|confirmed",
        ]);

        //Create user
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "User registered succesfully",
            "data" => []
        ]);
    }

     //POST [email, password]
    public function login (Request $request){

        $request->validate([
            "email" => "required|email|string",
            "password" => "required"
        ]);

        // User object
        $user = User::where("email", $request->email)->first();

        if(!empty($user)){
            // User exists
            if(Hash::check($request->password, $user->password)){
                //Password matched
              $token = $user->createToken('myToken')->accessToken;

                return response()->json([
                    "status" => true,
                    "message" => "Login succesful",
                    "token" => $token,
                    "data" => []
                ]);
            }else{

                return response()->json([
                    "status" => false,
                    "message" => "Password didn't match",
                    "data" => []
                ]);
            }
        }else{

            return response()->json([
                "status" => false,
                "message" => "invalid Email value",
                "data" => []
            ]);
        }
    }

     //GET [Auth: Token]
     public function profile (){
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile information",
            "data" => $userData,
            "id" => auth()->user()->id
        ]);

     }

     //GET [Auth: Token]
     public function logout()
     {
         $token = auth()->user()->token();

         $token->revoke();

         return response()->json([
             "status" => true,
             "message" => "User logged out successfully",


         ]);

     }
}
