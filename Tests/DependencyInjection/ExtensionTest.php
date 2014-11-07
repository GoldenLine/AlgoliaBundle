<?php

namespace Goldenline\AlgoliaBundle\Tests\DependencyInjection;


use Goldenline\AlgoliaBundle\DependencyInjection\GoldenlineAlgoliaExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class ExtensionTest extends AbstractExtensionTestCase
{

    /**
     * @inheritdoc
     */
    protected function getContainerExtensions()
    {
        return [
            new GoldenlineAlgoliaExtension()
        ];
    }

    public function testExtensionAfterLoading()
    {
        $this->load();
        $this->assertContainerBuilderHasService('goldenline.algolia.client', 'AlgoliaSearch\Client');
    }

    protected function getMinimalConfiguration()
    {
        return [
            'credentials' => [
                'application_id' => 'asasa',
                'search_key'     => 'sasa,
        '
            ]
        ];
    }
}
