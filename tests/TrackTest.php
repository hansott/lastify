<?php


namespace HansOtt\Lastify\Test;


use HansOtt\Lastify\Track;
use HansOtt\Lastify\Track\Artist;

class TrackTest extends \PHPUnit_Framework_TestCase
{
    public function test_constructor()
    {
        $name = 'song';
        $artist = new Artist('Hans Ott');
        $track = new Track($name, $artist);
        $this->assertEquals($name, $track->getName());
        $this->assertEquals($artist, $track->getArtist());
    }

    public function test_it_creates_correct_search_query()
    {
        $name = 'song';
        $artist = new Artist('Hans Ott');
        $track = new Track($name, $artist);
        $this->assertEquals(
            'song - Hans Ott',
            $track->getSearchQuery()
        );
    }
}