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
            return response()->json([
                "users" => $users,
                "current_user" => auth()->user()->id,
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "error" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            "email" => "required|unique:users",
        ]);
        try {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);
            return \response()->json([
                "message" => "User created successfully",
                "user" => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "message" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function edit(User $user): \Illuminate\Http\JsonResponse
    {
        try {
            return \response()->json([
                "user" => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "message" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public  function  update(Request $request, User $user){
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
            return \response()->json([
                "status" => Response::HTTP_OK,
                'message' => 'User updated successfully'
            ]);
        }catch (\Throwable $th) {
            return response()->json(
                [
                    "message" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    public function delete(User $user): \Illuminate\Http\JsonResponse
    {
        try {
            $user->delete();
            return \response()->json([
                "message" => "User deleted successfully",
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "message" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
