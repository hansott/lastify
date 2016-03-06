<?php

namespace HansOtt\Lastify;

final class SyncResult
{
    /**
     * @var array
     */
    private $ignored = [];

    /**
     * Add ignored track.
     *
     * @param TrackInfo $track
     */
    public function addIgnoredTrack(TrackInfo $track)
    {
        $this->ignored[] = $track;
    }

    /**
     * Get the ignored tracks.
     *
     * @return TrackCollection
     */
    public function getIgnored()
    {
        return new TrackCollection($this->ignored);
    }
}
