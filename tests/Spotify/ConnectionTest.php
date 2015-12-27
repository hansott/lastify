<?php

namespace HansOtt\Lastify\Test\Spotify;

use Mockery;
use HansOtt\Lastify\Spotify\SpotifyPlaylist;
use HansOtt\Lastify\Spotify\SpotifyApi;
use HansOtt\Lastify\Spotify\SpotifyUser;
use HansOtt\Lastify\Spotify\SpotifyConnection;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_sets_the_correct_user()
    {
        $userId = 'userId';
        $accessToken = 'accessToken';
        $connection = SpotifyConnection::connect($userId, $accessToken);
        $this->assertInstanceOf(SpotifyUser::class, $connection->getUser());
        $this->assertEquals($userId, $connection->getUser()->getUserId());
    }

    public function test_it_can_get_user_playlists()
    {
        $playlists = [
            new SpotifyPlaylist('Test', '111'),
            new SpotifyPlaylist('Test', '222'),
            new SpotifyPlaylist('Test', '333'),
        ];
        $spotifyUser = new SpotifyUser('userId');
        $spotifyApi = Mockery::mock(SpotifyApi::class);
        $spotifyApi
            ->shouldReceive('getUserPlaylists')
            ->once()
            ->andReturn($playlists);
        $connection = new SpotifyConnection($spotifyUser, $spotifyApi);
        $this->assertEquals($playlists, $connection->getUserPlaylists());
    }

    public function test_it_can_create_playlists()
    {
        $spotifyUser = new SpotifyUser('userId');
        $createdPlaylist = new SpotifyPlaylist('Test', '111');
        $spotifyApi = Mockery::mock(SpotifyApi::class);
        $spotifyApi
            ->shouldReceive('createPlaylist')
            ->withArgs([$createdPlaylist->getName(), $spotifyUser])
            ->once()
            ->andReturn($createdPlaylist);
        $connection = new SpotifyConnection($spotifyUser, $spotifyApi);
        $this->assertEquals($createdPlaylist, $connection->createPlaylist(
            $createdPlaylist->getName()
        ));
    }
    
    public function test_it_does_not_create_playlist_if_exists()
    {
        $existingPlaylist = new SpotifyPlaylist('Test1', '111');
        $playlists = [
            $existingPlaylist,
            new SpotifyPlaylist('Test2', '222'),
        ];
        $spotifyApi = Mockery::mock(SpotifyApi::class);
        $spotifyApi
            ->shouldReceive('getUserPlaylists')
            ->once()
            ->andReturn($playlists);
        $spotifyUser = new SpotifyUser('userId');
        $connection = new SpotifyConnection($spotifyUser, $spotifyApi);
        $this->assertEquals(
            $existingPlaylist,
            $connection->createPlaylistIfNotExists(
                $existingPlaylist->getName()
            )
        );
    }
}