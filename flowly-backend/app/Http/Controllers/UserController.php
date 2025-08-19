<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(["user with id: '$id' not found"], 404);
            }

            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
        ;
    }

    public function update(Request $request, $id)
    {
        try {
            $result = User::update($id, $request->all());
            if ($result === false) {
                return response()->json(['error' => "unable to update user with id: {$id}"], 500);
            }

            return response()->json(['result' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $result = User::destroy($id);
            if ($result === false) {
                return response()->json(['error' => "unable to delete user with id: {$id}"], 500);
            }

            return response()->json(['result' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}