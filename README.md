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
        "tonjoo/almari": "*"
    }
```

Basic Usage
-----------

The main container class is `Lotus\Almari\Container`

### Adding service
```php
use Lotus\Almari\Container as Container

$app = new Container();

// Create service, return new Foo instance
$app->bind('foo',function(){

	return new Foo();

});
```

### Retrieve Service
```
$newFoo = $app->make('foo');

$newFoo2 = $app->make('foo');
```

### Share singleton to container
```php
use Lotus\Almari\Container as Container

$app = new Container();

$foo = new Foo();

// Share an instance
$app->share('fooSingeleton',$foo);

// Share an instance (lazy load)
$app->shareDeferred('fooSingeleton',function(){

	return new Foo();

});

// Share instance using array access
$app['fooSingeleton'] = $foo;

```
### Retrieve instance
```php
$myFoo = app->get('foo',$defaultValue);

// Or using array access
$myFoo = app['foo'];

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
