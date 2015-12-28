<?php

namespace HansOtt\Lastify\Spotify;

class SpotifyPlaylist
{
    private $name;
    private $playlistId;

    public function __construct($name, $playlistId)
    {
        $this->name = $name;
        $this->playlistId = $playlistId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPlaylistId()
    {
        return $this->playlistId;
    }
}
