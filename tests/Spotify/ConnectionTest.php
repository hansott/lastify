<?php

namespace HansOtt\Lastify\Test\Spotify;

use HansOtt\Lastify\Spotify\SpotifyConnection;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_sets_the_correct_credentials()
    {
        $userId = '24243244';
        $accessToken = 'access-token';
        $connection = SpotifyConnection::connect($userId, $accessToken);
        $this->assertEquals($userId, $connection->getUser()->getUserId());
    }
}