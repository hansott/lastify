<?php

namespace HansOtt\Lastify\Test;

use HansOtt\Lastify\SynchronizerTarget;
use HansOtt\Lastify\Track;
use HansOtt\Lastify\Track\Artist;
use HansOtt\Lastify\TrackCollection;
use Mockery;
use HansOtt\Lastify\Synchronizer;
use HansOtt\Lastify\LastFm\LastFmConnection;
use HansOtt\Lastify\Spotify\SpotifyConnection;
use HansOtt\Lastify\Spotify\SpotifyPlaylist;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_can_sync_top_tracks()
    {
        $topTracks = new TrackCollection();
        $track = new Track('Song', new Artist('Hans Ott'));
        $topTracks->addTrack($track);
        $playlistName = 'Top Tracks';
        $playlistId = '123';
        $limit = 30;
        $spotifyPlaylist = new SpotifyPlaylist($playlistName, $playlistId);
        $target = Mockery::mock(SynchronizerTarget::class);
        $target
            ->shouldReceive('createPlaylistIfNotExists')
            ->once()
            ->withArgs([$playlistName])
            ->andReturn($spotifyPlaylist);
        $lastFm = Mockery::mock(LastFmConnection::class);
        $lastFm
            ->shouldReceive('getTopTracks')
            ->once()
            ->withArgs([$limit])
            ->andReturn($topTracks);
        $target
            ->shouldReceive('updatePlaylistTracks')
            ->once()
            ->withArgs([$spotifyPlaylist, $topTracks]);
        $manager = new Synchronizer($lastFm, $target);
        $manager->syncTopTracksToPlaylist($playlistName, $limit);
    }
}
