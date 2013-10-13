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

Add routes in your `app/config/routing.yml`:

```yml
tms_logger_api:
    resource: "@TmsLoggerBundle/Controller"
    type:     annotation
    prefix:   /api
```

Now import the bundle configuration in your `app/config/config.yml`

```yml
imports:
    ...
    - { resource: @TmsLoggerBundle/Resources/config/config.yml }
```

Now the Bundle is installed.


How to use
==========

Basic usage:
------------

Simply implements the LoggableInterface with Object that you wants to Log:

```php
use Tms\Bundle\LoggerBundle\Logger\LoggableInterface;

MyClass implements LoggableInterface
{
    ...

    /**
     * Get id
     *
     * @return int|string Something which identify in an unique way an object
     */
    public function getId()
    {
        ...
    }
}

```

Then you can log your object in two way:


Via the dependecy injection container:
--------------------------------------

```php
$this->getContainer()->get('tms_logger.logger_manager')->log(
    $objectOfMyClass,
    $action,
    $information
);
```

$action:
A string which identify the action.
ex: "update"

$information:
An array which can contains additional informations about the action.
ex: array('dataX' => array('old_value' => 'dummy', 'new_value' => 'ymmud'))

To retrieve the object logs, simply call the getLogs function:

```php
$this->getContainer()->get('tms_logger.logger_manager')->getLogs($objectOfMyClass);
```


Log with the event dispatcher:
------------------------------


```php
use \Tms\Bundle\LoggerBundle\Logger\LoggableInterface;
use Tms\Bundle\LoggerBundle\Event\LogEvents;
use Tms\Bundle\LoggerBundle\Event\LogEvent;

...

// CREATE

if($entity instanceof LoggableInterface) {
    $this->getEventDispatcher()->dispatch(
        LogEvents::PRE_CREATE,
        new LogEvent($entity)
    );
}

$this->getEntityManager()->persist($entity);
$this->getEntityManager()->flush();

if($entity instanceof LoggableInterface) {
    $this->getEventDispatcher()->dispatch(
        LogEvents::POST_CREATE,
        new LogEvent($entity)
    );
}

// UPDATE

if($entity instanceof LoggableInterface) {
    $this->getEventDispatcher()->dispatch(
        LogEvents::PRE_UPDATE,
        new LogEvent($entity)
    );
}

$this->getEntityManager()->persist($entity);
$this->getEntityManager()->flush();

if($entity instanceof LoggableInterface) {
    $this->getEventDispatcher()->dispatch(
        LogEvents::POST_UPDATE,
        new LogEvent($entity)
    );
}

// DELETE

if($entity instanceof LoggableInterface) {
    $this->getEventDispatcher()->dispatch(
        LogEvents::PRE_DELETE,
        new LogEvent($entity)
    );
}

$this->getEntityManager()->remove($entity);
$this->getEntityManager()->flush();

if($entity instanceof LoggableInterface) {
    $this->getEventDispatcher()->dispatch(
        LogEvents::POST_DELETE,
        new LogEvent($entity)
    );
}
```


