<?php

namespace HansOtt\Lastify;

use Iterator;

final class TrackCollection implements Iterator
{
    private $tracks;

    private $position = 0;

    /**
     * TrackCollection constructor.
     *
     * @param array $tracks An array of TrackInfo objects.
     */
    public function __construct(array $tracks = [])
    {
        $this->assertThatTheseAreAllTracks($tracks);
        $this->tracks = $tracks;
    }

    private function assertThatTheseAreAllTracks(array $tracks)
    {
        foreach ($tracks as $track) {
            if (! ($track instanceof TrackInfo)) {
                throw new \InvalidArgumentException(sprintf(
                    'Expected "%s", but instead got: "%s"',
                    TrackInfo::class,
                    is_object($track) ? get_class($track) : gettype($track)
                ));
            }
        }
    }

    public function current()
    {
        return $this->tracks[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->tracks[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Create a sync progress.
     *
     * @param SyncProgressCallback|null $callback
     *
     * @return SyncProgress
     */
    public function createSyncProgress(SyncProgressCallback $callback = null)
    {
        $total = count($this->tracks);

        return new SyncProgress(0, $total, $callback);
    }
}
