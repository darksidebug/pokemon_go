<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileContoller extends Controller
{
    public function index(Request $request)
    {
        $info = User::findOrFail($request->user_id);
        return response()->json(['info' => $info]);
    }

    public function updateInfo(Request $request)
    {
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'dateOfBirth' => ['required'],
        ]);

        User::where('id', $request->user_id)
            ->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'birthdate' => $request->dateOfBirth
            ]);
    }
}
