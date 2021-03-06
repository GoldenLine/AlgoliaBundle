AlgoliaBundle
=============

[![Dependency Status](https://www.versioneye.com/user/projects/55278b312ced4ffffe00061f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55278b312ced4ffffe00061f)

Integrates Algolia into Symfony

Installation
-------------

The best way to install this bundle is by using [Composer](http://getcomposer.org). Simply run:

``` bash
$ php composer.phar require goldenline/algolia-bundle 1.0.0
```

Then, enable the bundle:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Goldenline\AlgoliaBundle\GoldenlineAlgoliaBundle(),
    );
}
```

Finally add your configuration:
```yml
# app/config/config.yml

goldenline_algolia:
    client:
        application_id: <your_application_id>
        application_key: <your_application_key>
    indices:
        foo:
            name: prefix_foo
        bar:
            name: bar
```

Currently we don`t support XML configuration.

Usage
-----

Get your index from container i.e.:

```php
  $this->getContainer()->get('goldenline_algolia.index.foo');
```
and use it according to https://github.com/algolia/algoliasearch-client-php#search documentation.

You can also use client service located in container: `goldenline_algolia.client` according to https://github.com/algolia/algoliasearch-client-php

License
-------

This bundle is released under the MIT license. See the complete license in the
bundle:

    Resources/meta/LICENSE
