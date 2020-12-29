<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\BroadcastChatEvent;

class Chat extends Model
{

	protected $dispachesEvent = [
		'created' => BroadcastChatEvent::class
	];

    public function user(){
    	return $this->belongsToMany('App\User');
    }

    public function messages()
    {
    	return $this->hasMany('App\Message');
    }

    public function getMessagesPaginatedAttribute()
    {
        return $this->messages()->simplePaginate(10);
    }

    public function chatUnseenMessages(){
        return $this->hasManyThrough('App\SeenmessagesUsers','App\Message')->where('seen', '0');
    }

}
