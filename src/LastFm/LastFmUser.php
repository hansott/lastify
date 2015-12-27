<?php

namespace HansOtt\Lastify\LastFm;

use LastFm\LastFmCredentials;

class LastFmUser
{
    private $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }
}