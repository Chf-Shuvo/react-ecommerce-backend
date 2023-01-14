<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $users = User::all();
            return response()->json(["users" => $users]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "error" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public  function  store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'email' => 'required|unique:users'
        ]);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            return \response()->json(['message' => 'User created successfully','user'=>$user]);
        }catch (\Throwable $th) {
            return response()->json(
                [
                    "message" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
