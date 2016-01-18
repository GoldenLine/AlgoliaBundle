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

        $this->assertContainerBuilderHasService('goldenline_algolia.client.default_client');
        $this->assertContainerBuilderHasService('goldenline_algolia.client');
        $this->assertContainerBuilderHasService('goldenline_algolia.index.foo');
        $this->assertContainerBuilderHasService('goldenline_algolia.index.bar');
        $this->assertContainerBuilderHasService('goldenline_algolia.index.users');
    }

    protected function getMinimalConfiguration()
    {
        return [
            'client' => [
                'default_client' => [
                    'application_id'  => 'asasa',
                    'application_key' => 'sasa',
                    'default' => true,
                ]
            ],
            'indices' => [
                'foo' => [
                    'name' => 'prefix_foo_index',
                    'client' => 'default'
                ],
                'bar' => [
                    'name' => 'bar_index',
                    'client' => 'default'
                ],
                'users' => [
                    'name' => 'dev_users_index',
                    'client' => 'default'
                ],
            ]
        ];
    }
}
