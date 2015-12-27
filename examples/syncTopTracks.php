<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once __DIR__.'/../vendor/autoload.php';

use HansOtt\Lastify\Manager;
use HansOtt\Lastify\LastFm\LastFmConnection;
use HansOtt\Lastify\Spotify\SpotifyConnection;

$lastFmConnection = LastFmConnection::connect(
    'last.fm username',
    'last.fm api key',
    'last.fm shared secret'
);

$spotifyConnection = SpotifyConnection::connect(
    'spotify userId',
    'spotify access token'
);

$manager = new Manager($spotifyConnection, $lastFmConnection);
$manager->syncTopTracksToPlaylist('Top Tracks', 30);