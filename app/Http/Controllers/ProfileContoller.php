<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileContoller extends Controller
{
    public function index()
    {
        $info = User::findOrFail(Auth::id());
        return response()->json(['info' => $info]);
    }

    public function updateInfo(Request $request)
    {
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'dateOfBirth' => ['required'],
        ]);

        User::where('id', Auth::id())
            ->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'birthdate' => $request->dateOfBirth
            ]);
    }
}
