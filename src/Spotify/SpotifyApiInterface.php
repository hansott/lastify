<?php

namespace HansOtt\Lastify\Spotify;

use HansOtt\Lastify\TrackCollection;

interface SpotifyApiInterface
{
    public function getTrackIds(TrackCollection $tracks);

    public function updatePlaylistTracks(SpotifyUser $user, SpotifyPlaylist $playlist, TrackCollection $tracks);

    public function createPlaylist($playlistName, SpotifyUser $user);

    public function getUserPlaylists(SpotifyUser $user);
}