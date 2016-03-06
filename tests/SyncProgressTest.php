<?php

namespace HansOtt\Lastify\Test;

use HansOtt\Lastify\SyncProgress;
use HansOtt\Lastify\SyncProgressCallback;
use HansOtt\Lastify\TrackInfo;
use PHPUnit_Framework_TestCase;

class SyncProgressTest extends PHPUnit_Framework_TestCase
{
    public function test_it_calls_callback_on_progress()
    {
        $artist = new TrackInfo\Artist('Hans Ott');
        $track1 = new TrackInfo('Track 1', [$artist]);
        $track2 = new TrackInfo('Track 2', [$artist]);

        $callback = $this->getMock(SyncProgressCallback::class);

        $callback->expects($this->exactly(2))
                 ->method('onProgress')
                 ->withConsecutive(
                     [$this->equalTo(1), $this->equalTo(2), $this->equalTo($track1)],
                     [$this->equalTo(2), $this->equalTo(2), $this->equalTo($track2)]
                 );

        $progress = new SyncProgress(0, 2, $callback);
        $progress->step($track1);
        $progress->step($track2);
    }
}
