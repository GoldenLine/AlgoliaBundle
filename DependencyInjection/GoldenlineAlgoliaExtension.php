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

        foreach ($config['client'] as $name => $client) {
            $this->loadClient($client, $name, $container);
        }


        if (isset($config['indices'])) {
            $this->loadIndices($config['indices'], $container);
        }
    }

    /**
     * @param array            $client application credentials
     * @param string           $name
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    private function loadClient(array $client, $name, ContainerBuilder $container)
    {
        $clientDef = new DefinitionDecorator('goldenline_algolia.client_prototype');
        $clientDef->replaceArgument(0, $client['application_id']);
        $clientDef->replaceArgument(1, $client['application_key']);
        $clientDef->replaceArgument(2, $client['hosts']);

        $clientName = sprintf('goldenline_algolia.client.%s', $name);
        $container->setDefinition($clientName, $clientDef);

        // ustawienie aliasu dla `default`
        if (true === (bool) $client['default']) {
            if ($container->hasAlias('goldenline_algolia.client')) {
                throw new \Exception('Only one service should be set as `default`');
            }

            $container->setAlias('goldenline_algolia.client', $clientName);
        }
    }

    /**
     * @param array $indices array of indices names
     * @param ContainerBuilder $container
     */
    private function loadIndices(array $indices, ContainerBuilder $container)
    {
        foreach ($indices as $index => $values) {
            $indexDef = new DefinitionDecorator('goldenline_algolia.index_prototype');
            $indexDef->replaceArgument(0, new Reference(sprintf('goldenline_algolia.client.%s', $values['client'])));
            $indexDef->replaceArgument(1, $values['name']);

            $indexId = sprintf('goldenline_algolia.index.%s', $index);

            $container->setDefinition($indexId, $indexDef);
        }
    }
}
