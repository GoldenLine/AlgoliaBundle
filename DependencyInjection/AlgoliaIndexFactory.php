<?php

namespace Goldenline\AlgoliaBundle\DependencyInjection;

use AlgoliaSearch\Client;

class AlgoliaIndexFactory
{
    public function create(Client $client, $index)
    {
        return $client->initIndex($index);
    }
}
