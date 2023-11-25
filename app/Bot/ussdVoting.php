<?php

namespace App\Bot;

use BotMan\BotMan\Messages\Conversations\Conversation;

class ussdVoting extends Conversation
{

    public function __construct()
    {
    }
        public function run(){
        $this->ussdResponse();
    }

    public function ussdResponse()
    {

    }
}
