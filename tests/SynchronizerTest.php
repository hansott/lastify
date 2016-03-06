<?php

namespace HansOtt\Lastify\Test;

use HansOtt\Lastify\TrackInfo;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use HansOtt\Lastify\Synchronizer;
use HansOtt\Lastify\TrackCollection;
use HansOtt\Lastify\CanManagePlaylists;
use HansOtt\Lastify\Exception\PlaylistDoesNotExist;

class SynchronizerTest extends PHPUnit_Framework_TestCase
{
    private function getTrackCollection()
    {
        $artist = new TrackInfo\Artist('artist');
        $track = new TrackInfo('track', [$artist]);

        return new TrackCollection([
            $track,
        ]);
    }

    public function test_it_creates_a_playlist_if_not_exists()
    {
        $trackCollection = $this->getTrackCollection();

        $playlistName = 'playlist';

        $target = $this->getMock(CanManagePlaylists::class);

        $target->expects($this->once())
               ->method('getPlaylistId')
               ->with($this->equalTo($playlistName))
               ->willThrowException(new PlaylistDoesNotExist($playlistName));

        $target->expects($this->once())
               ->method('createPlaylist')
               ->with($this->equalTo($playlistName));

        $synchronizer = new Synchronizer($target);

        $synchronizer->syncToPlaylist($playlistName, $trackCollection);
    }

    public function test_it_throws_an_exception_for_an_invalid_playlist_name()
    {
        $trackCollection = $this->getTrackCollection();

        $target = $this->getMock(CanManagePlaylists::class);
        $synchronizer = new Synchronizer($target);

        $this->setExpectedException(InvalidArgumentException::class);
        $synchronizer->syncToPlaylist('', $trackCollection);

        $this->setExpectedException(InvalidArgumentException::class);
        $synchronizer->syncToPlaylist(1, $trackCollection);
    }
}
