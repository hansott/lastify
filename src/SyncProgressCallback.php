<?php

namespace HansOtt\Lastify;

use HansOtt\Lastify\TrackInfo;

interface SyncProgressCallback
{
    /**
     * Process a sync update.
     *
     * @param int $current The new position.
     * @param int $total The total items in the track collection.
     * @param \HansOtt\Lastify\TrackInfo $currentItem The current track.
     */
    public function onProgress($current, $total, TrackInfo $currentItem);
}
