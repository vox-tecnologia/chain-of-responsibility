# Chain Of Responsibility Pattern
This light library helps to implement quickly a chain of responsibility. This pattern is especially useful when you need a clear process that involve multiple steps.


## Installation

The suggested installation method is via composer:

```
composer require vox-tecnologia/chain-of-responsibility
```

## Elements

### Context
Object to send information into handlers. 
You can create custom context class (with Vox\Chain\Context\ContextInterface) or use basic context (Vox\Chain\Context\Context).

### Handler
This object is able to understand the context and ensure execution if necessary.
It can also add another object of the same type.

### Manager
Object that makes magic happen.
It is able to understand and make happen the whole flow of the Chain.

## How to use

- Create a context
```php
use Vox\Chain\Context\Context;
```
```php
$context = new Context();
$context->set('foo', 1);
$context->set('bar', 5);
```

- Create Handler
```php
use Vox\Chain\Handler\ChainHandlerInterface;

class FirstDethFirstHandler implements ChainHandlerInterface
{
...
```
```php
use Vox\Chain\Handler\ChainHandlerInterface;

class FirstDethSecoundHandler implements ChainHandlerInterface
{
...
```

```php
use Vox\Chain\Handler\ChainHandlerInterface;

class SecoundDethOneHandler implements ChainHandlerInterface
{
...
```


- To finish, build and run the manager 

```php
use Vox\Chain\ChainManager;
```

```php
$manager = new ChainManager();

$manager
    ->addHandler(new FirstDethFirstHandler)
    ->addHandler(new FirstDethSecoundHandler)
;
$manager->addHandler(new SecoundDethOneHandler);

$manager->run($context);
```


