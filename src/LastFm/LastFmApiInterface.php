<?php

namespace HansOtt\Lastify\LastFm;

interface LastFmApiInterface
{
    public function getTopTracks(LastFmUser $user, $limit = 10);
}
