<?php

namespace HansOtt\Lastify;

use HansOtt\Lastify\LastFm\LastFmConnection;

class Synchronizer
{
    private $target;
    private $source;

    public function __construct(LastFmConnection $source, SynchronizerTarget $target)
    {
        $this->target = $target;
        $this->source = $source;
    }

    public function syncTopTracksToPlaylist($playlistName, $limit = 10)
    {
        $spotifyPlaylist = $this->target->createPlaylistIfNotExists($playlistName);
        $tracks = $this->source->getTopTracks($limit);
        $this->target->updatePlaylistTracks($spotifyPlaylist, $tracks);
    }
}
