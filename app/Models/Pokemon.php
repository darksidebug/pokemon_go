<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemons';

    protected $fillable = [
        'pokemon_id',
        'name',
        'isLike',
        'user_id'
    ];

    public static function countLikes()
    {
        return self::where('isLike', 1)->count();
    }

    public static function countDislikes()
    {
        return self::where('isLike', 2)->count();
    }

    public function pokemons()
    {
        return $this->belongsTo(User::class, 'id', 'users_id');
    }
}
