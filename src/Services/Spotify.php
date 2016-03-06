<?php

namespace HansOtt\Lastify\Services;

use HansOtt\Lastify\SyncProgress;
use HansOtt\Lastify\TrackInfo;
use HansOtt\Lastify\SyncResult;
use InvalidArgumentException;
use SpotifyWebAPI\SpotifyWebAPI;
use HansOtt\Lastify\TrackCollection;
use HansOtt\Lastify\TrackInfo\Artist;
use HansOtt\Lastify\CanManagePlaylists;
use HansOtt\Lastify\Exception\PlaylistDoesNotExist;

final class Spotify implements CanManagePlaylists
{
    private $api;

    private $userId = null;

    public function __construct(SpotifyWebAPI $api)
    {
        $this->api = $api;
    }

    public static function connect($accessToken)
    {
        static::assertValidAccessToken($accessToken);
        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return new static($api);
    }

    private static function assertValidAccessToken($accessToken)
    {
        if (!is_string($accessToken)) {
            throw new InvalidArgumentException('The access token should be a string, instead got:' . gettype($accessToken));
        }

        if (empty($accessToken)) {
            throw new InvalidArgumentException('The access token cannot be empty');
        }
    }

    private function getSearchQuery(TrackInfo $info)
    {
        $addArtistName = function($artistNames, Artist $artist) {
            return $artistNames . $artist->getName();
        };

        $artistNames = array_reduce($info->getArtists(), $addArtistName, '');

        return $info->getName() . ' ' . $artistNames;
    }

    private function getTrackId(TrackInfo $track)
    {
        $options = [
            'type' => 'track',
        ];

        $query = $this->getSearchQuery($track);
        $result = $this->api->search($query, $options);

        $tracks = is_array($result->tracks->items) ? $result->tracks->items : [];

        if (empty($tracks)) {
            return null;
        }

        $firstMatch = array_shift($tracks);

        return !empty($firstMatch->id) ? $firstMatch->id : null;
    }

    private function fetchUserPlaylists()
    {
        $response = $this->api->getMyPlaylists();

        return isset($response->items) ? $response->items : [];
    }

    public function getPlaylistId($name)
    {
        $playlists = $this->fetchUserPlaylists();

        foreach ($playlists as $playlist) {
            if ($playlist->name == $name) {
                return $playlist->id;
            }
        }

        throw new PlaylistDoesNotExist($name);
    }

    private function getUserId()
    {
        if (isset($this->userId)) {
            return $this->userId;
        }

        $user = $this->api->me();
        $userId = (int) $user->id;
        $this->userId = $userId;

        return $userId;
    }

    public function createPlaylist($name)
    {
        $this->assertValidPlaylistName($name);

        $options = [
            'name' => $name
        ];

        $createdPlaylist = $this->api->createUserPlaylist($this->getUserId(), $options);

        return $createdPlaylist->id;
    }

    private function assertValidPlaylistName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('The playlist name should be a string, instead got:' . gettype($name));
        }
        if (empty($name)) {
            throw new InvalidArgumentException('The playlist name cannot be empty');
        }
    }

    public function replacePlaylistTracks($playlistId, TrackCollection $newTracks, SyncProgress $progress)
    {
        $syncResult = new SyncResult();
        $trackIds = [];

        foreach ($newTracks as $track) {
            $progress->step($track);
            $trackId = $this->getTrackId($track);

            if (empty($trackId)) {
                $syncResult->addIgnoredTrack($track);
            }
            else {
                $trackIds[] = $trackId;
            }
        }

        $this->api->replaceUserPlaylistTracks(
            $this->getUserId(),
            $playlistId,
            $trackIds
        );

        return $syncResult;
    }
}
