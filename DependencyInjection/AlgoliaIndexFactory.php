<?php

namespace Goldenline\AlgoliaBundle\DependencyInjection;

use AlgoliaSearch\Client;

class AlgoliaIndexFactory
{
    public static function create(Client $client, $index)
    {
        return $client->initIndex($index);
    }
}
