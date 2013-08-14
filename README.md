Aliaser
=======

Simple PHP library for parsing and handling class and function aliases defined by `USE` statements.

Usage
-----

**Book.php**

Here we have an entity class `Book` with some annotations:

```php
namespace Model\Entities;

use \DateTime;

/**
 * @property User $author
 * @property DateTime $written
 */
class Book
{}

function foo()
{}
```

**foo.php**

And now let's say we would like to take those annotations and get the full class name of those `@property` types defined. And that's where we'll use `Aliaser`:

```php
$reflection = new ReflectionClass('Model\Entities\Book');

Aliaser\Container::getClass('User', $reflection); // 'Model\Entities\User'
Aliaser\Container::getClass('DateTime', $reflection); // 'DateTime'
```

We can discover full function/callback name according to given namespace context as well.

```php
Aliaser\Container::getCallback('DateTime::format', $reflection); // 'DateTime::format'
Aliaser\Container::getCallback('User::getName', $reflection); // 'Model\Entities\User::getName'

Aliaser\Container::getCallback('foo', $reflection); // 'Model\Entities\foo'
```

It handles multiple namespace definitions in a single file as well.

However, parsing can be quite expensive - we can use a [Nette Framework](http://doc.nette.org/en/caching) Cache:

```php
$storage = new Nette\Caching\Storages\FileStorage(__DIR__ . '/temp');
Aliaser\Container::setCacheStorage($storage);

// ...
```

Enjoy.
