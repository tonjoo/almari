Almari
======
Almari is a micro IoC framework which implement service locator and facade pattern

Installation
============
You can use composer to install Almari

```
composer require lotus/almari
```

Or you can put it on `composer.json`

```json
"require": {
        "lotus/almari": "*"
    }
```

Basic Usage
-----------

The main container class is `Lotus\Almari\Container`

### Adding service to container
```php
use Lotus\Almari\Container as Container

$app = new Container();


$foo = new Foo();

// Share a service as singeleton
$app->share('fooSingeleton',$foo);

// Using closure
$app->share('fooSingeleton',function(){

        return new Foo();

        });
        
// register a service to container
$app->register('foo',$foo);

```
### Retrieve service
```php
$app->get('foo',$defaultValue);

```

### Facade ability

Full example here : https://github.com/tonjoo/almari-boilerplate

```php
// Facading $foo to FooFacade
$aliasMapper = AliasMapper::getInstance();

$alias['FooFacade'] = 'MyProject\MyPackage\Facade\FooFacade';

$aliasMapper->facadeClassAlias($alias);

//Register container to facade
MyFacade::setFacadeContainer($app);

FooFacade::greet("Todi");
```
