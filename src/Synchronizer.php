<?php

namespace HansOtt\Lastify;

use HansOtt\Lastify\Exception\PlaylistDoesNotExist;
use InvalidArgumentException;

final class Synchronizer
{
    /**
     * @var CanManagePlaylists The target.
     */
    private $target;

    /**
     * Synchronizer constructor.
     *
     * @param CanManagePlaylists $target The target.
     */
    public function __construct(CanManagePlaylists $target) {
        $this->target = $target;
    }

    /**
     * Sync a track collection to a playlist.
     *
     * @param string $name The name of the target playlist.
     * @param TrackCollection $source The track collection to sync to the playlist.
     * @param SyncProgressCallback|null $callback The progress callback.
     *
     * @return SyncResult
     */
    public function syncToPlaylist($name, TrackCollection $source, SyncProgressCallback $callback = null)
    {
        $this->assertValidPlaylistName($name);
        $syncProgress = $source->createSyncProgress($callback);
        $playlistId = $this->getPlaylistId($name);

        return $this->target->replacePlaylistTracks($playlistId, $source, $syncProgress);
    }

    /**
     * Assert that the playlist name is valid.
     *
     * @param string $name
     */
    private function assertValidPlaylistName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('The playlist name should be a string, instead got:' . gettype($name));
        }
        if (empty($name)) {
            throw new InvalidArgumentException('The playlist name cannot be empty');
        }
    }

    /**
     * Get the playlist id of a playlist.
     *
     * If the playlist not exists, the playlist will be created.
     *
     * @param string $name
     *
     * @return string The playlist id.
     */
    private function getPlaylistId($name)
    {
        try {
            return $this->target->getPlaylistId($name);
        } catch (PlaylistDoesNotExist $e) {
            return $this->target->createPlaylist($name);
        }
    }
}
