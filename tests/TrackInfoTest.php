<?php

namespace HansOtt\Lastify\Test;

use InvalidArgumentException;
use HansOtt\Lastify\TrackInfo;
use PHPUnit_Framework_TestCase;

class TrackInfoTest extends PHPUnit_Framework_TestCase
{
    public function test_it_returns_the_full_track_name_as_a_string()
    {
        $artist = new TrackInfo\Artist('Fat Freddy\'s Drop');
        $track = new TrackInfo('Razor', [$artist]);
        $fullString = $track->toString();
        $this->assertEquals('Razor - Fat Freddy\'s Drop', $fullString);
    }

    public function test_it_throws_an_exception_for_empty_name()
    {
        $artist = new TrackInfo\Artist('artist');
        $this->setExpectedException(InvalidArgumentException::class);
        new TrackInfo('', [$artist]);
    }

    public function test_it_throws_an_exception_when_no_artists()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new TrackInfo('track', []);
    }
}
