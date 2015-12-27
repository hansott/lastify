<?php

namespace HansOtt\Lastify;

use HansOtt\Lastify\LastFm\LastFmConnection;
use HansOtt\Lastify\Spotify\SpotifyConnection;

class Manager
{
    private $spotify;
    private $lastFm;

    public function __construct(SpotifyConnection $spotify, LastFmConnection $lastFm)
    {
        $this->spotify = $spotify;
        $this->lastFm = $lastFm;
    }

    public function syncTopTracksToPlaylist($playlistName, $amount = 10)
    {
        $spotifyPlaylist = $this->spotify->createPlaylistIfNotExists($playlistName);
        $tracks = $this->lastFm->getTopTracks($amount);
        $this->spotify->updatePlaylistTracks($spotifyPlaylist, $tracks);
    }
}