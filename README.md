# PHP Diff library
This is a PHP mini library to work with *differences* in two arrays. It's way of
doing things is inspired by the way [Git](http://www.git-scm.com) works, only simplified.

## Using the library
Using the diff library isn't hard. You create a new instance of the class
and you pass along your data arrays in the constructor and call one of the utility methods:

```php
<?php
$diff = new Sfranken\Diff($a, $b);
print '<pre>' . print_r($diff->toArray(), true) . '</pre>';
?>
```

See the [index.php](https://github.com/sebastiaanfranken/php-diff-library/blob/master/index.php) file for a more *in depth* example of how to use this class

The `toArray` function shows the result as an array which you can work with later on.

## Supported methods
The class has the following methods:

- [`__construct`](https://github.com/sebastiaanfranken/php-diff-library/blob/2.1/src/Sfranken/Diff.php#L33-L82)
- [`toArray`](https://github.com/sebastiaanfranken/php-diff-library/blob/2.1/src/Sfranken/Diff.php#L90-L93)
- [`toObject`](https://github.com/sebastiaanfranken/php-diff-library/blob/2.1/src/Sfranken/Diff.php#L102-L105)
- [`toJSON`](https://github.com/sebastiaanfranken/php-diff-library/blob/2.1/src/Sfranken/Diff.php#L113-L116)
- [`getAction`](https://github.com/sebastiaanfranken/php-diff-library/blob/2.1/src/Sfranken/Diff.php#L127-L150)
- [`getAltered`](https://github.com/sebastiaanfranken/php-diff-library/blob/2.1/src/Sfranken/Diff.php#L160-L163)
- [`getAdded`](https://github.com/sebastiaanfranken/php-diff-library/blob/2.1/src/Sfranken/Diff.php#L173-L176)
- [`getRemoved`](https://github.com/sebastiaanfranken/php-diff-library/blob/2.1/src/Sfranken/Diff.php#L186-L189)
- [`getSingle`](https://github.com/sebastiaanfranken/php-diff-library/blob/2.1/src/Sfranken/Diff.php#L200-L203)

## Demo image
Since an image is worth a thousand words..
![php diff image](https://raw.githubusercontent.com/sebastiaanfranken/php-diff-library/master/demo.png)
