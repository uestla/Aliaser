Aliaser
=======

Simple PHP library for parsing and handling class aliases defined by `USE` statements.

Usage
-----

**Book.php**

Here we have an entity class `Book` with some annotations:

```php
<?php

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
<?php

$aliaser = new Aliaser\Container;
$reflection = new ReflectionClass('Model\Entities\Book');

$file = $reflection->getFileName();
$namespace = $reflection->getNamespaceName();

$aliaser->getClass('User', $file, $namespace); // 'Model\Entities\User'
$aliaser->getClass('DateTime', $file, $namespace); // 'DateTime'
```

It handles multiple namespace definitions in a single file as well.

However, the parsing can be quite expensive, so we can use a [Nette Framework](http://nette.org) Cache:

```php
<?php

$storage = new Nette\Caching\Storages\FileStorage(__DIR__ . '/temp');
$aliaser = new Aliaser\Container($storage);

// ...
```

Enjoy.
