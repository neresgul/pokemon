<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = ['pokeapi_id','name','experience'];

    public function users(){
    	return $this->belongsToMany(User::class);
    }
}

