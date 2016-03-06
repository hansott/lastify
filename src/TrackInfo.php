<?php

namespace HansOtt\Lastify;

use InvalidArgumentException;
use HansOtt\Lastify\TrackInfo\Artist;

final class TrackInfo
{
    private $name;

    private $artists;

    public function __construct($name, array $artists = [])
    {
        $this->assertValidName($name);
        $this->assertThatTheseAreAllArtists($artists);
        $this->name = $name;
        $this->artists = $artists;
    }

    private function assertValidName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('The name should be a string, instead got:' . gettype($name));
        }
        if (empty($name)) {
            throw new InvalidArgumentException('The name cannot be empty');
        }
    }

    private function assertThatTheseAreAllArtists(array $artists)
    {
        if (empty($artists)) {
            throw new InvalidArgumentException('A track should always have an artist');
        }

        foreach ($artists as $artist) {
            if (! ($artist instanceof Artist)) {
                throw new \InvalidArgumentException(sprintf(
                    'Expected "%s", but instead got: "%s"',
                    Artist::class,
                    is_object($artist) ? get_class($artist) : gettype($artist)
                ));
            }
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getArtists() {
        return $this->artists;
    }

    public function toString()
    {
        $artists = array_map(function(Artist $artist) {
            return $artist->getName();
        }, $this->artists);

        return sprintf('%s - %s', $this->name, implode(', ', $artists));
    }

    public function __toString()
    {
        return $this->toString();
    }
}
