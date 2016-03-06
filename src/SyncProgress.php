<?php

namespace HansOtt\Lastify;

use InvalidArgumentException;

final class SyncProgress
{
    private $current;

    private $total;

    private $callback = null;

    public function __construct($initial = 0, $total, SyncProgressCallback $callback = null)
    {
        $this->assertValidArguments($initial, $total);
        $this->current = (int) $initial;
        $this->total = (int) $total;

        if (isset($callback)) {
            $this->callback = $callback;
        }
    }

    public function step(TrackInfo $currentItem)
    {
        $this->current++;
        $this->callProgressCallback($currentItem);
    }

    private function callProgressCallback($currentItem)
    {
        if ($this->callback instanceof SyncProgressCallback) {
            $this->callback->onProgress($this->current, $this->total, $currentItem);
        }
    }

    private function assertValidArguments($initial, $total)
    {
        if (!is_int($initial)) {
            throw new InvalidArgumentException('The initial value should be an integer, instead got:' . gettype($initial));
        }
        if ($initial < 0) {
            throw new InvalidArgumentException('The initial value should be a positive integer');
        }
        if (!is_int($total)) {
            throw new InvalidArgumentException('The total value should be an integer, instead got:' . gettype($total));
        }
        if ($total < 0) {
            throw new InvalidArgumentException('The total value should be a positive integer');
        }
        if ($total <= $initial) {
            throw new InvalidArgumentException('The total value should be a greater than the initial value.');
        }
    }
}
