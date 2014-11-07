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

        $this->assertContainerBuilderHasService('goldenline_algolia.client','a');
        $this->assertContainerBuilderHasService('goldenline_algolia.index.foo');
        $this->assertContainerBuilderHasService('goldenline_algolia.index.bar');
        $this->assertContainerBuilderHasService('goldenline_algolia.index.users');
    }

    protected function getMinimalConfiguration()
    {
        return [
            'client' => [
                'application_id'  => 'asasa',
                'application_key' => 'sasa',
            ],
            'indices' => [
                'foo',
                'bar',
                'users',
            ]
        ];
    }
}
