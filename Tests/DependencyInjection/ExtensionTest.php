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
        $this->assertContainerBuilderHasService('goldenline.algolia.index.foo', 'AlgoliaSearch\Index');
        $this->assertContainerBuilderHasService('goldenline.algolia.index.bar', 'AlgoliaSearch\Index');
        $this->assertContainerBuilderHasService('goldenline.algolia.index.users', 'AlgoliaSearch\Index');
    }

    protected function getMinimalConfiguration()
    {
        return [
            'credentials' => [
                'application_id' => 'asasa',
                'search_key'     => 'sasa',
            ],
            'indices' => [
                'foo',
                'bar',
                'users',
            ]
        ];
    }
}
