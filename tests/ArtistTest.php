<?php

namespace HansOtt\Lastify\Test;

use HansOtt\Lastify\TrackInfo\Artist;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class ArtistTest extends PHPUnit_Framework_TestCase
{
    public function test_it_throws_exception_for_invalid_name()
    {
        $this->setExpectedException(InvalidArgumentException::class);
        new Artist('');

        $this->setExpectedException(InvalidArgumentException::class);
        new Artist(1);
    }
}
