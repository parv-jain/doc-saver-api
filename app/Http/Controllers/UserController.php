<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAuthenticatedUser(Request $request)
    {
        $decodedRequest = json_decode(base64_decode($request->header('apiToken')), true);
        $email = $decodedRequest['email'];
        $password = $decodedRequest['password'];
        return response()->json(User::with(['documents'])->where('email', $email)->where('password', $password)->first());
    }

    public function addNewUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);
        $user = User::create($request->all());
        return response()->json($user, 201);
    }
}
