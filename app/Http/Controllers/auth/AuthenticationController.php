<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{
    public function login(Request $request): \Illuminate\Http\JsonResponse|string
    {
        try {
            $user = User::where('email',$request->email)->first();
            $authenticated = Hash::check($request->password,$user->password);
            if ($user && $authenticated) {
                $token = $user->createToken("auth_token");
                return response()->json([
                    "status" => Response::HTTP_OK,
                    "token" => $token->plainTextToken,
                    "user" => $user,
                ]);
            } else {
                return response()->json([
                    "status" => Response::HTTP_UNAUTHORIZED,
                    "response" => "Incorrect email/password",
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "response" => $th->getMessage(),
            ]);
        }
    }


    public function checkIfAuthenticated(): \Illuminate\Http\JsonResponse|string
    {
        try {
            return response()->json([
                'status' => 200,
                'message' => 'authenticated'
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

}
