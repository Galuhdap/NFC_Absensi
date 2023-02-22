<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Rendi push hehe anj ayo gelud heheh
    public function login(Request $request)
    {
        try {
            $request->validate([
                'nbi' => 'required',
                'password' => 'required',
            ]);
            $credentials = request(['nbi', 'password']);

            if (!Auth::attempt($credentials)) {
                return $this->sendError('Unauthorized', 'Authentication Failed', 500);
            }
            $user = User::where('nbi', $request->nbi)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return $this->sendResponse([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (Exception $error) {
            dd($error);
            return $this->sendError(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Login Failed',
            );
        }
    }
    public function register(Request $request)
    {
        try {

            $request->validate([
                'name' => ['required', 'string', 'max:100'],
                'nbi' => ['required', 'string', 'max:100'],
                'password' => ['required', 'min:6'],
                'role_id' => ['required', 'integer']
            ]);

            User::create([
                'name' => $request->name,
                'nbi' => $request->nbi,
                'password' => Hash::make($request->password),
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
            return $this->sendError(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Registration Failed',
            );
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = User::find(Auth::user()->id);

            $user->tokens()->delete();

            return $this->sendResponse($user, 'Successfull Logout');
        } catch (Exception $error) {
            return $this->sendError(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Registration Failed',
            );
        }
    }

    public function onlyAdmin(Request $request)
    {
        $user = User::find(Auth::user()->id);
        dd($user);
        if (!$user) return response()->json("User tidak ditemukan");

        // if ($user.role !== "admin") return response()->json("Acces Terlarang");
    }
}
