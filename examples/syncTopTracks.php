<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once __DIR__.'/../vendor/autoload.php';

use HansOtt\Lastify\TrackInfo;
use HansOtt\Lastify\Synchronizer;
use HansOtt\Lastify\Services\LastFm;
use HansOtt\Lastify\Services\Spotify;
use HansOtt\Lastify\SyncProgressCallback;

$lastFm = LastFm::connect('your-lastfm-api-key');
$spotify = Spotify::connect('your-spotify-access-token');

$synchronizer = new Synchronizer($spotify);
$topTracks = $lastFm->getTopTracks('your-lastfm-username', 25);
$lovedTracks = $lastFm->getLovedTracks('your-lastfm-username', 25);

class ProgressCallback implements SyncProgressCallback {
    public function onProgress($current, $total, TrackInfo $currentItem)
    {
        echo sprintf("[%s/%s] Syncing %s \n", $current, $total, $currentItem->toString());
    }
}

$synchronizer->syncToPlaylist('Top Tracks', $topTracks, new ProgressCallback());
$synchronizer->syncToPlaylist('Loved Tracks', $lovedTracks, new ProgressCallback());
