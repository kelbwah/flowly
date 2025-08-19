<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginUserRequest;

class LoginController extends Controller
{
    public function store(LoginUserRequest $request)
    {
        try {
            if (array_key_exists("email", array: $request->all())) {
                $searchKey = "email";
                $searchValue = $request->all()["email"];
            } else if (array_key_exists("username", $request->all())) {
                $searchKey = "username";
                $searchValue = $request->all()["username"];
            }
            ;

            $user = User::where($searchKey, $searchValue)->firstOrFail();
            if (!password_verify($request["password"], $user->password)) {
                throw new \Exception("invalid credentials");
            }
            ;

            unset($user["password"]);

            $sessionCookie = cookie("session", $user->id, 10080);
            print (string) $sessionCookie . "\n";
            return response()->json(["user" => $user], 200)->withCookie($sessionCookie);
        } catch (\Exception $e) {
            return response()->json(["error" => "invalid credentials."], 409);
        }
        ;
    }
}