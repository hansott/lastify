<?php


namespace HansOtt\Lastify;


class TrackCollection
{
    private $tracks;

    public function __construct(array $tracks = [])
    {
        $this->setTracks($tracks);
    }

    public function addTrack(Track $track)
    {
        $this->tracks[] = $track;
    }

    public function getTracks()
    {
        return $this->tracks;
    }

    public function setTracks(array $tracks)
    {
        foreach ($tracks as $track) {
            $this->addTrack($track);
        }
    }
}