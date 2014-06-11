almari
======

Almari is a micro IoC framework which implement service locator and facade pattern

Installation
============

You can use composer to install Almari

```
composer require lotus/almari
```

Or you can put it on `composer.json'

```json
"require": {
        "lotus/almari": "*"
    }
```

Basic Usage
-----------

The main container class is `Lotus\Almari\Container`

###Adding service to container

```php
use Lotus\Almari\Container as Container

$app = new Container();


```
