<?php

namespace HansOtt\Lastify\Exception;

use Exception;

final class PlaylistDoesNotExist extends Exception
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
