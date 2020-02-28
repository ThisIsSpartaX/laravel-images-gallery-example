<?php

namespace App\Service;

class KrakenService extends \Kraken
{
    public function __construct()
    {
        parent::__construct(config('kraken.api_key'), config('kraken.api_secret'));
    }
}