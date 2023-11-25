<?php

namespace App\Http\Controllers\App\Bot;

class ussdVoting
{

    public function __construct()
    {
    }

    public function run()
    {
        // This will be called immediately
        $this->askFirstname();
    }
}
