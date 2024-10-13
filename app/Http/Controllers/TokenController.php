<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class TokenController extends Controller
{
    public function createToken($user_id){

        $user = User::find($request->input($user_id));
        if ($user) {
            $user->token = Crypt::encryptString($request->input('token'));
            $user->save();
            return response()->json(['status' => 'success', 'token'=>"$user"]);
        } else {
            return response()->json(['status' => 'Error: User not found'], 404);
        }


    }
    public function decryptToken($user_id){
        try {
            $decryptedToken = Crypt::decryptString($token);
            return response()->json(['status' => 'success', 'decrypt token'=>"$decryptedToken"]);
        } catch (DecryptException $e) {
            return response()->json(['status' => 'Error decrypting token'], 400);
        }

    }
}
