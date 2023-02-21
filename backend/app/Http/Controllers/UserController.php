<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'string', 'max:100'],
                'nbi' => ['required', 'string', 'max:100'],
                'role_id' => ['required', 'integer'],


            ]);

            User::create([
                'name' => $request->name,
                'nbi' => $request->nbi,
                'role_id' => $request->role_id,
            ]);

            $user = User::where('nbi', $request->nbi)->first();
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            $user->remember_token = $tokenResult;
            $user->save();

            $data = [
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ];
            return $this->sendResponse($data, 'Successfull Register');
        } catch (Exception $error) {
            echo ($error);
            return $this->sendError(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Registration Failed',
            );
        }
    }
}
