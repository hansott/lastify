<?php

namespace HansOtt\Lastify\LastFm;

use Dandelionmood\LastFm\LastFm;
use HansOtt\Lastify\Track;
use HansOtt\Lastify\Track\Artist;
use stdClass;

class LastFmApi implements LastFmApiInterface
{
    private $api;

    public function __construct(LastFm $api)
    {
        $this->api = $api;
    }

    private function fetchTopTracks(LastFmUser $user, $amount)
    {
        $response = $this->api->user_getTopTracks([
            'user' => $user->getUsername(),
            'limit' => $amount,
        ]);
        $topTracks = isset($response->toptracks) && is_array($response->toptracks->track)
            ? $response->toptracks->track
            : [];
        return $topTracks;
    }

    private function convertToTrack(stdClass $lastFmTrack)
    {
        $artist = new Artist($lastFmTrack->artist->name);
        return new Track($lastFmTrack->name, $artist);
    }

    public function getTopTracks(LastFmUser $user, $limit = 10)
    {
        $topTracks = $this->fetchTopTracks($user, $limit);
        return array_map(function($lastFmTrack) {
            return $this->convertToTrack($lastFmTrack);
        }, $topTracks);
    }
}