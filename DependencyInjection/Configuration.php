<?php

namespace Goldenline\AlgoliaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('goldenline_algolia');

        $rootNode
            ->children()
                ->arrayNode('credentials')
                    ->isRequired()
                    ->children()
                        ->scalarNode('application_id')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('search_key')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->arrayNode('hosts')
                            ->prototype('scalar')->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('indices')
                    ->prototype('scalar')->cannotBeEmpty()->end()
                ->end()
            ->end()
        ;


        return $treeBuilder;
    }
}
