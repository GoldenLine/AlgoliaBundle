<?php

namespace Goldenline\AlgoliaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
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

        $this->loadClient($config['client'], $container);

        if (isset($config['indices'])) {
            $this->loadIndices($config['indices'], $container);
        }
    }

    /**
     * @param array $client application credentials
     * @param ContainerBuilder $container
     */
    private function loadClient(array $client, ContainerBuilder $container)
    {
        $clientDef = new DefinitionDecorator('goldenline_algolia.client_prototype');
        $clientDef->replaceArgument(0, $client['application_id']);
        $clientDef->replaceArgument(1, $client['application_key']);
        $clientDef->replaceArgument(2, $client['hosts']);

        $container->setDefinition('goldenline_algolia.client', $clientDef);
    }

    /**
     * @param array $indices array of indices names
     * @param ContainerBuilder $container
     */
    private function loadIndices(array $indices, ContainerBuilder $container)
    {
        foreach ($indices as $index) {
            $indexDef = new DefinitionDecorator('goldenline_algolia.index_prototype');
            $indexDef->replaceArgument(0, new Reference('goldenline_algolia.client'));
            $indexDef->replaceArgument(1, $index);

            $indexId = sprintf('goldenline_algolia.index.%s', $index);

            $container->setDefinition($indexId, $indexDef);
        }
    }
}
