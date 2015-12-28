<?php

namespace HansOtt\Lastify;

use HansOtt\Lastify\LastFm\LastFmConnection;
use HansOtt\Lastify\Spotify\SpotifyConnection;

class Synchronizer
{
    private $target;
    private $source;

    public function __construct(SpotifyConnection $spotify, LastFmConnection $lastFm)
    {
        $this->target = $spotify;
        $this->source = $lastFm;
    }

    public function syncTopTracksToPlaylist($playlistName, $limit = 10)
    {
        $spotifyPlaylist = $this->target->createPlaylistIfNotExists($playlistName);
        $tracks = $this->source->getTopTracks($limit);
        $this->target->updatePlaylistTracks($spotifyPlaylist, $tracks);
    }
}
