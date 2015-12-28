<?php

namespace HansOtt\Lastify\LastFm;

use Dandelionmood\LastFm\LastFm;
use HansOtt\Lastify\TrackCollection;

class LastFmConnection
{
    private $user;
    private $api;

    public function __construct(LastFmUser $user, LastFmApiInterface $api)
    {
        $this->user = $user;
        $this->api = $api;
    }

    public static function connect($username, $apiKey, $sharedSecret)
    {
        $api = new LastFm($apiKey, $sharedSecret);
        $api = new LastFmApi($api);
        $user = new LastFmUser($username);
        return new static($user, $api);
    }

    public function getTopTracks($limit = 10)
    {
        $topTracks = $this->api->getTopTracks($this->user, $limit);
        return new TrackCollection($topTracks);
    }
}
