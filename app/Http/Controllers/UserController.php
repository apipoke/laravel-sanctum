<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
Use App\Http\Resources\UserResource;
Use App\Http\Resources\UserCollection;

class UserController extends Controller
{

  function index(Request $request)
  {
      $user= User::where('email', $request->email)->first();

      if (!$user || !Hash::check($request->password, $user->password)) {
          return response([
              'message' => ['These credentials do not match our records.']
          ], 404);
      }

       $token = $user->createToken('my-app-token')->plainTextToken;

      $response = [
          'user' => $user,
          'token' => $token
      ];

      return response($response, 201);
  }

  public function users(){

    // return new UserResource(User::all());
    // return UserResource::collection(User::all());
    return new UserCollection(User::all());
  }
}
