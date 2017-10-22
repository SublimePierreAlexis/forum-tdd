<?php

namespace App;

class Spam
{
    public function detect($body)
    {
        $this->detectInvalidKeywords($body);

        return false;
    }

    protected function detectInvalidKeywords($body)
    {
        $invalidsKeywords = [
            'yahoo customer support',
        ];

        foreach ($invalidsKeywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains spam.');
            }
        }
    }
}
