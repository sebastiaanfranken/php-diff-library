# PHP Diff library
This is a PHP mini library to work with *differences* in two arrays. It's way of
doing things is inspired by the way [Git](http://www.git-scm.com) works, only simplified.

## Using the library
Using the diff library isn't hard. You create a new instance of the class
and you pass along your data arrays in the constructor and call one of the utility methods:

	$diff = new Diff($a, $b);
	print '<pre>' . print_r($diff->toArray(), true) . '</pre>';

The `toArray` function shows the result as an array which you can work with later on.

## Supported methods
The class has the following methods:

- [`__construct`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L46-L88)
- [`toArray`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L96-L99)
- [`toObject`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L107-L110)
- [`toJSON`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L118-L121)
- [`getKey`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L130-L133)
- [`getKeys`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L141-L154)
- [`getAlpha`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L163-L166)
- [`getAlphas`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L174-L187)
- [`getBeta`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L196-L199)
- [`getBetas`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L207-L220)
- [`getAction`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L229-L232)
- [`getActions`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L240-L253)
- [`getAltered`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L261-L274)
- [`getRemoved`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L282-L294)
- [`getAdded`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L303-L316)
- [`getA`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L324-L327)
- [`setA`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L335-L339)
- [`getB`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L347-L350)
- [`setB`](https://github.com/sebastiaanfranken/php-diff-library/blob/master/Diff.php#L358-L362)

## Demo image
Since an image is worth a thousand words..
![php diff image](https://raw.githubusercontent.com/sebastiaanfranken/php-diff-library/master/demo.png)
