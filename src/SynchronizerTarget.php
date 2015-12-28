<?php

namespace HansOtt\Lastify;

use HansOtt\Lastify\Spotify\SpotifyPlaylist;

interface SynchronizerTarget
{
    public function getUserPlaylists();

    public function createPlaylist($playlistName);

    public function playlistExists($playlistName);

    public function createPlaylistIfNotExists($playlistName);

    public function updatePlaylistTracks(SpotifyPlaylist $playlist, TrackCollection $tracks);
}
