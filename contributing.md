# Contributing to ConFOMO

This project follows the [PSR-1](http://www.php-fig.org/psr/psr-1/) and [PSR-2](http://www.php-fig.org/psr/psr-2/) coding styles.

It follows a few conventions in addition to the recommendations set out in these style guides.

* Logical NOT (!) operators should have a single character of whitespace after them

```php
if (! $condition)
// rather than
if (!$condition)
```

* Multi-line arrays should have a trailing comma

```php
$array = [
    'value1',
    'value2',
    'finalvalue',
];
```

* Single arrays should not have a trailing comma

```php
$array = ['value1', 'value2', 'value3'];
```

* Order use statements alphabetically
* Remove lines between use statements
* Return statements should be preceded by an empty line feed
* PHP arrays should use the PHP 5.4 short-syntax (`[...]` rather than `array(...)`)
* Short scalar casting (use `bool`, `int` rather than `boolean`, `integer` and `float` rather than `double` or `real`)
* Arrays should be formatted like function / method arguments; that is, without leading or trailing whitespace
* Don't align double arrows (in associative arrays)
* Don't align equals symbols
* Remove unused use statements

A [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) configuration file (`.php_cs`) is included in this repository.

You can apply the rules manually, or by adding our simple `pre-commit` git hook with the commands below.

```bash
chmod +x .githooks/pre-commit
ln -sf ../../.githooks/pre-commit .git/hooks/pre-commit
```
