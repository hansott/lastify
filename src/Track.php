<?php

namespace HansOtt\Lastify;

use HansOtt\Lastify\Track\Artist;

class Track
{
    private $name;
    private $artist;

    public function __construct($name, Artist $artist)
    {
        $this->name = $name;
        $this->artist = $artist;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getArtist()
    {
        return $this->artist;
    }

    public function getSearchQuery()
    {
        return sprintf('%s - %s', $this->name, $this->artist->getName());
    }
}