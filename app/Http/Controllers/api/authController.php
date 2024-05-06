<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class authController extends Controller
{
    // public function register(Request $request)
    // {
    //     try
    //     {
    //         $validation = validator($request->all(), [
    //             "username" =>"required",
    //             "email"=> "required",
    //             "password"=> "required|min:6",
    //             "bio" => "required",
    //             "is_private"=> "required|boolean",
    //             ]);
    //             if ($validation->fails())
    //             {
    //                 return response()->json([
    //                     "error"=> $validation->errors()->first(),
    //                     "message"=> $validation->errors()->first(),
    //                     ],);
    //     }
    //     $user = User::create([
    //         "full_name"=> $request->full_name,
    //         "username"=> $request->username,
    //         "email"=> $request->email,
    //         "bio" => $request->bio,
    //         'is_private'=> $request->is_private,
    //         "password" => bcrypt($request->password)
    //         ]);
    //     return response()->json([
    //         "token" => $user->createToken("auth_token")->plainTextToken,
    //         "message"=> "Register success",
    //         "user"=> $user
    //         ],201);
    //     }
    //     catch (\Exception $e)
    //     {
    //         return response()->json([
    //             "error"=> $e->getMessage(),
    //             "message"=> $e->getMessage()
    //             ],500);
    //     }
    // }

    public function register(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            "full_name"=>"required",
            "username" =>"required",
            "email"=> "required",
            "password"=> "required|min:6",
            "bio" => "required",
            "is_private"=> "required|boolean",
        ]);

        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'error' => $errors
            ], 400);
        }

        // Check if validation pass then create user and auth token. Return the auth token
        if ($validator->passes()) {
            $user = User::create([
            "full_name"=> $request->full_name,
            "username"=> $request->username,
            "email"=> $request->email,
            "bio" => $request->bio,
            'is_private'=> $request->is_private,
            "password" => bcrypt($request->password)
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
    }
    // public function login(Request $request)
    // {
    //     try
    //     {
    //         $validation = validator($request->all(), [
    //             "username"=> "required",
    //             "password"=> "required|min:6",
    //             ]);

    //         if ($validation->fails())
    //         {
    //             return response()->json([
    //                 "error"=> $validation->errors()->first(),
    //                 "message"=> $validation->errors()->first(),
    //                 ],500);

    //         }
    //         if(! auth::attempt($request ->only("username","password")))
    //         {
    //             return response()->json([
    //                 "alert" => "Wrong username or password",
    //                 "error"=> $validation->errors()->first(),
    //                 "message"=> $validation->errors()->first(),
    //                 ],500);
    //         }
    //         $token = auth::user()->createToken("auth_token")->plainTextToken;
    //         $user = User::where("username",
    //         $request -> username)->first();
    //         return response()->json([
    //             "token"=>$token,
    //             "message"=> "Login success",
    //             ],200);

    // }
    // catch (\Exception $e)
    // {
    //     return response()->json([
    //         "error"=> $e->getMessage(),
    //         "message"=> $e->getMessage()
    //         ],500);
    // }
    // }

public function login(Request $request)
{
    if (!Auth::attempt($request->only('username', 'password'))) {
        return response()->json([
            'message' => 'Invalid login details'
        ], 401);
    }

    $user = User::where('username', $request['username'])->firstOrFail();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}
    public function me(Request $request)
    {
        return response()->json(auth('api')->user());
}
}
