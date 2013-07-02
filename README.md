Aliaser
=======

Simple PHP library for parsing and handling class aliases defined by `USE` statements.

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
```

**foo.php**

And now let's say we would like to take those annotations and get the full class name of those `@property` types defined. And that's where we'll use `Aliaser`:

```php
$reflection = new ReflectionClass('Model\Entities\Book');

Aliaser\Container::getClass('User', $reflection); // 'Model\Entities\User'
Aliaser\Container::getClass('DateTime', $reflection); // 'DateTime'
```

It handles multiple namespace definitions in a single file as well.

However, parsing can be quite expensive - we can use a [Nette Framework](http://nette.org) Cache:

```php
$storage = new Nette\Caching\Storages\FileStorage(__DIR__ . '/temp');
Aliaser\Container::setCacheStorage($storage);

// ...
```

Enjoy.
