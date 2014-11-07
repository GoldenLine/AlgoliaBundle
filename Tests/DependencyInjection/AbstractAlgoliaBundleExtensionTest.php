<?php

namespace Goldenline\AlgoliaBundle\Tests\DependencyInjection;

use Goldenline\AlgoliaBundle\DependencyInjection\GoldenlineAlgoliaExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class AbstractAlgoliaBundleExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $extension;
    private $container;

    protected function setUp()
    {
        $this->extension = new GoldenlineAlgoliaExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    abstract protected function loadConfiguration(ContainerBuilder $container, $resource);

    public function testProperConfiguration()
    {
        $this->loadConfiguration($this->container, 'config');
        $this->container->compile();
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testMissingApplicationIdParameter()
    {
        $this->loadConfiguration($this->container, 'missing_application_id_parameter');
        $this->container->compile();
    }

    /**
     * * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testMissingSearchKeyParameter()
    {
        $this->loadConfiguration($this->container, 'missing_search_key_parameter');
        $this->container->compile();
    }
}
