<?php

namespace HansOtt\Lastify;

use HansOtt\Lastify\Exception\PlaylistDoesNotExist;

interface CanManagePlaylists
{
    /**
     * Get the playlist id.
     *
     * @param string $name The name of the playlist.
     *
     * @return mixed The playlist id.
     *
     * @throws PlaylistDoesNotExist
     */
    public function getPlaylistId($name);

    /**
     * Creates a playlist.
     *
     * @param string $name The name of the playlist.
     *
     * @return mixed The playlist id.
     */
    public function createPlaylist($name);

    /**
     * Replace the playlist tracks with new tracks.
     *
     * @param mixed $playlistId The playlist id.
     * @param TrackCollection $newTracks The new playlist tracks.
     * @param SyncProgress $progress
     *
     * @return SyncResult
     */
    public function replacePlaylistTracks($playlistId, TrackCollection $newTracks, SyncProgress $progress);
}
