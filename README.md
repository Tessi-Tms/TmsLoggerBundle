TmsLoggerBundle
===============

Symfony2 logger bundle


Installation
============

To install this bundle please follow the next steps:

First add the dependency in your `composer.json` file:

```json
"repositories": [
    ...,
    {
        "type": "vcs",
        "url": "https://github.com/Tessi-Tms/TmsLoggerBundle.git"
    }
],
"require": {
        ...,
        "tms/logger-bundle": "dev-master"
    },
```

Then install the bundle with the command:

```sh
php composer update
```

Enable the bundle in your application kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tms\Bundle\LoggerBundle\TmsLoggerBundle(),
    );
}
```

Now the Bundle is installed.