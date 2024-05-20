<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class FCMController extends Controller
{
    //
    public function index(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'fcm_token' => 'required',
        ]);
        $user = User::findOrFail($validatedData['user_id']);
        $user->fcm_token = $validatedData['fcm_token'];
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Token saved successfully'
        ]);
    }
}
