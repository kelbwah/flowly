<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterUserRequest;

class RegisterController extends Controller
{
    public function store(RegisterUserRequest $request)
    {
        try {
            $formattedUser = [];
            foreach ($request->all() as $key => $value) {
                if ($key === "password") {
                    $passwordHash = password_hash($request->password, PASSWORD_BCRYPT);
                    $formattedUser[$key] = $passwordHash;
                } else {
                    $formattedUser[$key] = $value;
                }
                ;
            }
            ;

            $createdUser = User::create($formattedUser);
            $createdUser->toArray();

            unset($createdUser["password"]);

            return response()->json(["user" => $createdUser], 200);
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 11000:
                    return response()->json(["error" => "user already exists."], 409);
                default:
                    return response()->json($e, 500);
            }
            ;
        }
        ;
    }
}