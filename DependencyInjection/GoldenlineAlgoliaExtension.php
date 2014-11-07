<?php

namespace Goldenline\AlgoliaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class GoldenlineAlgoliaExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $this->createAlgoliaClient($container, $config);

        if (isset($config['indices'])) {
            $this->createAlgoliaIndices($container, $config['indices']);
        }
    }

    /**
     * @param $config
     * @param ContainerBuilder $container
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    private function createAlgoliaClient(ContainerBuilder $container, $config)
    {
        if (!class_exists('AlgoliaSearch\Client')) {
            throw new \RuntimeException(
                'You must require "algolia/algoliasearch-client-php" to use the Algolia Bundle.'
            );
        }

        $algoliaClient = new Definition('AlgoliaSearch\Client');
        $algoliaClient->addArgument($config['credentials']['application_id']);
        $algoliaClient->addArgument($config['credentials']['search_key']);
        if (isset($config['credentials']['hosts'])) {
            $algoliaClient->addArgument($config['credentials']['hosts']);
        }

        $container->setDefinition('goldenline.algolia.client', $algoliaClient);
    }

    /**
     * @param ContainerBuilder $container
     * @param array $indices
     * @throws \RuntimeException
     */
    private function createAlgoliaIndices(ContainerBuilder $container, array $indices)
    {
        if (!class_exists('AlgoliaSearch\Index')) {
            throw new \RuntimeException(
                'You must require "algolia/algoliasearch-client-php" to use the Algolia Bundle.'
            );
        }

        foreach ($indices as $index) {
            $algoliaIndex = new Definition('AlgoliaSearch\Index');
            $algoliaIndex->setFactoryClass('Goldenline\AlgoliaBundle\DependencyInjection\AlgoliaIndexFactory');
            $algoliaIndex->setFactoryMethod('create');
            $algoliaIndex->addArgument(new Reference('goldenline.algolia.client'));
            $algoliaIndex->addArgument($index);

            $container->setDefinition(sprintf('goldenline.algolia.index.%s', $index), $algoliaIndex);
        }
    }
}
