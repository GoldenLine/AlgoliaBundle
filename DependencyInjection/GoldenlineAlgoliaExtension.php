<?php

namespace Goldenline\AlgoliaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
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
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $this->createAlgoliaClient($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param $config
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    private function createAlgoliaClient(ContainerBuilder $container, $config)
    {
        if (!$container->hasDefinition('goldenline.algolia.client')) {
            if (!class_exists('AlgoliaSearch\Client')) {
                throw new \RuntimeException(
                    'You must require "algolia/algoliasearch-client-php" to use the Algolia Bundle.'
                );
            }

            // Validate the config
            if (empty($config['credentials']['application_id']) || empty($config['credentials']['search_key'])) {
                throw new \InvalidArgumentException(
                    'The `application_id` and `search_key` must be set in your configuration file to use the Algolia Bundle'
                );
            }

            $algoliaClient = new Definition('AlgoliaSearch\Client');
            $algoliaClient->addArgument($config['credentials']['application_id']);
            $algoliaClient->addArgument($config['credentials']['search_key']);

            $container->setDefinition('goldenline.algolia.client', $algoliaClient);
        }
    }
}
