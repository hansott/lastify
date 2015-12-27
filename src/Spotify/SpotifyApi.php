<?php

namespace HansOtt\Lastify\Spotify;

use HansOtt\Lastify\Track;
use HansOtt\Lastify\TrackCollection;
use SpotifyWebAPI\SpotifyWebAPI;
use stdClass;

class SpotifyApi implements SpotifyApiInterface
{
    private $api;

    public function __construct(SpotifyWebAPI $api)
    {
        $this->api = $api;
    }

    private function searchTrackId(Track $track)
    {
        $result = $this->api->search($track->getSearchQuery(), [
            'type' => 'track',
        ]);
        $tracks = is_array($result->tracks->items) ? $result->tracks->items : [];
        if (empty($tracks)) {
            return null;
        }
        $firstMatch = array_shift($tracks);
        return isset($firstMatch->id) ? $firstMatch->id : null;
    }

    public function getTrackIds(TrackCollection $tracks)
    {
        $tracks = array_map(function(Track $track) {
            return $this->searchTrackId($track);
        }, $tracks->getTracks());
        return array_filter($tracks);
    }

    public function createPlaylist($playlistName, SpotifyUser $user)
    {
        $createdPlaylist = $this->api->createUserPlaylist($user->getUserId(), [
            'name' => $playlistName
        ]);
        return $this->convertPlaylist($createdPlaylist);
    }

    private function convertPlaylist(stdClass $playlist)
    {
        return new SpotifyPlaylist($playlist->name, $playlist->id);
    }

    private function fetchUserPlaylists(SpotifyUser $user)
    {
        $response = $this->api->getUserPlaylists($user->getUserId());
        return isset($response->items) ? $response->items : [];
    }

    private function ownsPlaylist(stdClass $playlist, SpotifyUser $user)
    {
        if (isset($playlist->owner)) {
            return $playlist->owner->id == $user->getUserId();
        }
        return false;
    }

    public function getUserPlaylists(SpotifyUser $user)
    {
        $playlists = $this->fetchUserPlaylists($user);
        $playlists = $this->filterPlaylistsNotOwnedByUser($user, $playlists);
        return $this->mapPlaylists($playlists);
    }

    public function updatePlaylistTracks(SpotifyUser $user, SpotifyPlaylist $playlist, TrackCollection $tracks)
    {
        $trackIds = $this->getTrackIds($tracks);
        $this->api->replaceUserPlaylistTracks(
            $user->getUserId(),
            $playlist->getPlaylistId(),
            $trackIds
        );
    }

    private function filterPlaylistsNotOwnedByUser(SpotifyUser $user, $playlists)
    {
        $playlists = array_filter($playlists, function (stdClass $playlist) use ($user) {
            return $this->ownsPlaylist($playlist, $user);
        });
        return $playlists;
    }

    private function mapPlaylists($playlists)
    {
        return array_map(function (stdClass $playlist) {
            return $this->convertPlaylist($playlist);
        }, $playlists);
    }
}