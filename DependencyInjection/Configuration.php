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
        $rootNode    = $treeBuilder->root('goldenline_algolia');

        $rootNode
            ->children()
                ->arrayNode('client')
                    ->isRequired()
                    ->prototype('array')
                        ->children()
                        ->scalarNode('application_id')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('application_key')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->arrayNode('hosts')
                            ->prototype('scalar')->defaultNull()->end()
                                ->end()
                                ->booleanNode('default')
                                    ->defaultFalse()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('indices')
                        ->prototype('array')
                            ->children()
                            ->scalarNode('name')->isRequired()->end()
                            ->scalarNode('client')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
