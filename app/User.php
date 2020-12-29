<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','birth_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function firendsOfMine(){
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id');
    }

    public function firendOf(){
        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends(){
        return $this->firendsOfMine->merge( $this->firendOf );
    }

    public function chat(){
        return $this->belongsToMany('App\Chat');
    }

    public function unseenMessages(){
        return $this->hasMany('App\SeenmessagesUsers')->where('seen',0);
    }

    public function sentRequests(){
        return $this->hasMany('App\FriendRequest', 'sender');
    }

    public function receivedRequests(){
        return $this->belongsToMany('App\User', 'friend_requests', 'receiver', 'sender');
    }

}
