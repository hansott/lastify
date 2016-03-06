<?php

namespace HansOtt\Lastify\Services;

use Dandelionmood\LastFm\LastFm as LastFmWrapper;
use HansOtt\Lastify\TrackInfo;
use HansOtt\Lastify\TrackCollection;
use HansOtt\Lastify\TrackInfo\Artist;
use InvalidArgumentException;

final class LastFm
{
    private $api;

    public function __construct(LastFmWrapper $api)
    {
        $this->api = $api;
    }

    public static function connect($apiKey)
    {
        $api = new LastFmWrapper($apiKey);

        return new static($api);
    }

    private function fetchTopTracks($username, $limit)
    {
        $params = [
            'user' => $username,
            'limit' => $limit,
        ];

        $response = $this->api->user_getTopTracks($params);

        $topTracks = isset($response->toptracks) && is_array($response->toptracks->track)
            ? $response->toptracks->track
            : [];

        return $topTracks;
    }

    private static function convertToTrackCollection(array $tracks)
    {
        $convertTrack = function ($track) {
            return static::convertToTrack($track);
        };

        $tracks = array_map($convertTrack, $tracks);

        return new TrackCollection($tracks);
    }

    private static function convertToTrack($track)
    {
        $artist = new Artist($track->artist->name);

        return new TrackInfo($track->name, [$artist]);
    }

    private function assertValidUsername($username)
    {
        if (!is_string($username)) {
            throw new InvalidArgumentException('The username should be a string, instead got:' . gettype($username));
        }
        if (empty($username)) {
            throw new InvalidArgumentException('The username cannot be empty');
        }
    }

    public function getTopTracks($username, $limit = 50)
    {
        $this->assertValidUsername($username);
        $topTracks = $this->fetchTopTracks($username, $limit);
        $topTracks = static::convertToTrackCollection($topTracks);

        return $topTracks;
    }

    public function getLovedTracks($username, $limit = 50)
    {
        $lovedTracks = $this->fetchLovedTracks($username, $limit);
        $lovedTracks = static::convertToTrackCollection($lovedTracks);

        return $lovedTracks;
    }

    private function fetchLovedTracks($username, $limit)
    {
        $params = [
            'user' => $username,
            'limit' => $limit,
        ];

        $response = $this->api->user_getLovedTracks($params);

        $lovedTracks = isset($response->lovedtracks) && is_array($response->lovedtracks->track)
            ? $response->lovedtracks->track
            : [];

        return $lovedTracks;
    }
}
