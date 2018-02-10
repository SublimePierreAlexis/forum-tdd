<?php

namespace App;

use Illuminate\Support\Facades\Redis;

trait RecordsVisits
{

    /**
     * Increment the redis Key by 1
     * @return RecordsVisits
     */
    public function recordVisit()
    {
        Redis::incr($this->visitsCacheKey());

        return $this;
    }

    /**
     * Returns the number of visits for this thread
     */
    public function visits()
    {
        return Redis::get($this->visitsCacheKey()) ?? 0;
    }

    public function resetVisits()
    {
        Redis::del($this->visitsCacheKey());

        return $this;
    }

    protected function visitsCacheKey()
    {
        return "threads.{$this->id}.visits";
    }
}