<?php

namespace jvleeuwen\broadsoft\Classes;

use Illuminate\Support\Facades\App;

class Socket
{
    public static function Send($channel, $event, $data)
    {
        $pusher = App::make('pusher');

        $pusher->trigger(
            $channel,
            $event, 
            $data
        );
        return Null;
    }
}