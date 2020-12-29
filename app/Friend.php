<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = ['user_id', 'friend_id'];

    public function chat(){
    	return $this->belongsToMany('App\Chat')->wherePivot('user_id',$this->id);
    }
    public function user(){
    	return $this->belongsToMany('App\User')->wherePivot('friend_id',$this->id);
    }
}
