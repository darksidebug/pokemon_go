<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PokemonContoller extends Controller
{
    public function addPokemonToLikes(Request $request)
    {
        $count = Pokemon::countLikes();
        $isLikeAlready = Pokemon::where('pokemon_id', $request->id)
                            ->where('user_id', Auth::id())
                            ->where('isLike', 1)
                            ->get();

        $isDislikeAlready = Pokemon::where('pokemon_id', $request->id)
                            ->where('user_id', Auth::id())
                            ->where('isLike', 2)
                            ->get();
                            
        if(count($isLikeAlready) > 0){
            return response()->json(['statusText' => 'Not Allowed', 'status' => 405, 'err' => 'You already liked this pokemon']);
        }

        if(count($isDislikeAlready) > 0){
            return response()->json(['statusText' => 'Not Allowed', 'status' => 406, 'err' => 'You have disliked this pokemon. Are you sure you want to like?']);
        }

        if($count >= 3){
            return response()->json(['statusText' => 'Not Allowed', 'status' => 405, 'count' => 'You have reach the minimum of 4 likes.']);
        }

        Pokemon::create([
            'pokemon_id' => $request->id,
            'name' => $request->name,
            'isLike' => 1,
            'user_id' => Auth::id()
        ]);
    }

    public function addPokemonToDislikes(Request $request)
    {
        $count = Pokemon::countDislikes();
        $isDislikeAlready = Pokemon::where('pokemon_id', $request->id)
                            ->where('user_id', Auth::id())
                            ->where('isLike', 2)
                            ->get();
        $isLikeAlready = Pokemon::where('pokemon_id', $request->id)
                            ->where('user_id', Auth::id())
                            ->where('isLike', 1)
                            ->get();
                            
        if(count($isDislikeAlready) > 0){
            return response()->json(['statusText' => 'Not Allowed', 'status' => 405, 'err' => 'You already disliked this pokemon']);
        }

        if(count($isLikeAlready) > 0){
            return response()->json(['statusText' => 'Not Allowed', 'status' => 406, 'err' => 'You have liked this pokemon. Are you sure you want to dislike?']);
        }

        if($count >= 3){
            return response()->json(['statusText' => 'Not Allowed', 'status' => 405, 'count' => 'You have reach the minimum of 4 dislikes.']);
        }

        Pokemon::create([
            'pokemon_id' => $request->id,
            'name' => $request->name,
            'isLike' => 2,
            'isFavorate' => 0,
            'user_id' => Auth::id()
        ]);
    }

    public function addPokemonToFavorate(Request $request)
    {
        $isLikeAlready = Pokemon::where('pokemon_id', $request->id)
                            ->where('user_id', Auth::id())
                            ->where('isLike', 1)
                            ->get();

        $isAddedToFavorateAlready = Pokemon::where('pokemon_id', $request->id)
                            ->where('user_id', Auth::id())
                            ->where('isFavorate', 1)
                            ->get();

        $isDislikeAlready = Pokemon::where('pokemon_id', $request->id)
                            ->where('user_id', Auth::id())
                            ->where('isLike', 2)
                            ->get();

        if(count($isDislikeAlready) > 0){
            return response()->json(['statusText' => 'Not Allowed', 'status' => 406, 'err' => 'You have disliked this pokemon. Are you sure you want to add to favorate?']);
        }

        if(count($isAddedToFavorateAlready) > 0){
            return response()->json(['statusText' => 'Not Allowed', 'status' => 405, 'err' => 'You already added this pokemon to favorate.']);
        }

        if(count($isLikeAlready) > 0){
            Pokemon::where('pokemon_id', $request->id)
                    ->where('user_id', Auth::id())
                    ->update(['isFavorate' => 1]);
        }else{
            Pokemon::create([
                'pokemon_id' => $request->id,
                'name' => $request->name,
                'isFavorate' => 1,
                'user_id' => Auth::id()
            ]);
        }
    }

    public function changePokemonToFavorate(Request $request)
    {
        Pokemon::where('pokemon_id', $request->id)
                ->where('user_id', Auth::id())
                ->update(['isFavorate' => 1, 'pokemons.isLike' => 3]);
    }

    public function changePokemonToDislikes(Request $request)
    {
        Pokemon::where('pokemon_id', $request->id)
                    ->where('user_id', Auth::id())
                    ->update(['isLike' => 2, 'isFavorate' => 2]);
    }

    public function changePokemonToLikes(Request $request)
    {
        Pokemon::where('pokemon_id', $request->id)
                    ->where('user_id', Auth::id())
                    ->update(['isLike' => 1]);
    }

    public function getUserLikePokemons(Request $request)
    {
        $users = Pokemon::join('users', 'users.id', '=', 'pokemons.user_id')
                    ->where('pokemons.isLike', 1)
                    ->where('pokemons.pokemon_id', $request->id)
                    ->get();

        return response()->json(['users'=>$users]);
    }

    public function getUserDislikePokemons(Request $request)
    {
        $users = Pokemon::join('users', 'users.id', '=', 'pokemons.user_id')
                    ->where('pokemons.isLike', 2)
                    ->where('pokemons.pokemon_id', $request->id)
                    ->get();

        return response()->json(['users'=>$users]);
    }

    public function getUserFavoratePokemons(Request $request)
    {
        $users = Pokemon::join('users', 'users.id', '=', 'pokemons.user_id')
                    ->where('pokemons.isFavorate', 1)
                    ->where('pokemons.isLike', '!=', 2)
                    ->where('pokemons.pokemon_id', $request->id)
                    ->get();

        return response()->json(['users'=>$users]);
    }

    public function myCollections(Request $request)
    {
        $pokemons = Pokemon::where('user_id', $request->user_id)
                            ->get();

        return response()->json(['pokemons' => $pokemons]);
    }
}
