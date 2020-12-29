<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeenmessagesUsers extends Model
{
    protected $table = "seenmessages_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id','user_id'
    ];

    public function message(){
    	return $this->belongsTo('App\Message');
    }
    
}
