<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Content extends Authenticatable
{
    use Notifiable;

    protected $table = 'boomclap.content_vlist';
    protected $fillable = [
        'no','singer','song_title','content_fname','creator','cpost_title','cpost_text'
    ];

}
