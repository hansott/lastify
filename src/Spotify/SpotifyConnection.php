<?php

namespace HansOtt\Lastify\Spotify;

use HansOtt\Lastify\TrackCollection;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyConnection
{
    private $user;
    private $api;

    public function __construct(SpotifyUser $user, SpotifyApiInterface $api)
    {
        $this->user = $user;
        $this->api = $api;
    }

    public static function connect($userId, $accessToken)
    {
        $user = new SpotifyUser($userId);
        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $api = new SpotifyApi($api);
        return new static($user, $api);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getApi()
    {
        return $this->api;
    }

    public function getUserPlaylists()
    {
        return $this->api->getUserPlaylists($this->user);
    }

    public function createPlaylist($playlistName)
    {
        return $this->api->createPlaylist($playlistName, $this->user);
    }

    public function playlistExists($playlistName)
    {
        $playlists = $this->getUserPlaylists();
        foreach ($playlists as $playlist) {
            if ($this->equals($playlistName, $playlist)) {
                return $playlist;
            }
        }
        return null;
    }

    public function createPlaylistIfNotExists($playlistName)
    {
        if ($playlist = $this->playlistExists($playlistName)) {
            return $playlist;
        }
        return $this->createPlaylist($playlistName);
    }

    public function updatePlaylistTracks(SpotifyPlaylist $playlist, TrackCollection $tracks)
    {
        $this->api->updatePlaylistTracks($this->user, $playlist, $tracks);
    }

    private function equals($playlistName, SpotifyPlaylist $playlist)
    {
        return $playlistName == $playlist->getName();
    }
}
