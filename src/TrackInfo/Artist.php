<?php

namespace HansOtt\Lastify\TrackInfo;

use InvalidArgumentException;

final class Artist
{
    private $name;

    public function __construct($name)
    {
        $this->assertValidName($name);
        $this->name = $name;
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

    public function getName()
    {
        return $this->name;
    }
}
