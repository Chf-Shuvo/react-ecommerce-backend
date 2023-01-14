<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function profile()
    {
        try {
            return response()->json(["response" => auth()->user()]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "response" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function logout()
    {
        try {
            $user = auth()->user();
            $user->tokens()->delete();
            return response()->json([
                "status" => Response::HTTP_OK,
                "message" => "User logged out successfully!",
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
}
