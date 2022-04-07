<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\PokemonContoller;
use App\Http\Controllers\ProfileContoller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/authenticate', function () {
    return response()->json([
        'statusText' => 'OK',
        'status' => 200
    ]);
});

Route::post('register', [RegisterUserController::class, 'index']);
Route::post('login', [LoginUserController::class, 'index']);
Route::post('sign-out', [LoginUserController::class, 'logout']);
Route::post('add-to-like', [PokemonContoller::class, 'addPokemonToLikes']);
Route::post('add-to-dislike', [PokemonContoller::class, 'addPokemonToDislikes']);
Route::post('change-to-dislike', [PokemonContoller::class, 'changePokemonToDislikes']);
Route::post('change-to-like', [PokemonContoller::class, 'changePokemonToLikes']);
Route::post('users-liked-this-pokemon', [PokemonContoller::class, 'getUserLikePokemons']);
Route::post('users-disliked-this-pokemon', [PokemonContoller::class, 'getUserDislikePokemons']);
Route::get('my-profile', [ProfileContoller::class, 'index']);
Route::post('update-my-profile', [ProfileContoller::class, 'updateInfo']);