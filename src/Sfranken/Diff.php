<?php

/**
 * Compare a number of arrays and return the differences
 *
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */

namespace Sfranken;

class Diff
{
	const ADDED = 'ADDED';
	const REMOVED = 'REMOVED';
	const ALTERED = 'ALTERED';

	/**
	 * The resulting diff as an array
	 *
	 * @access protected
	 * @var array
	 */
	protected $diff = [];

	/**
	 * Create a new Diff class instance with a variadic number of
	 * arrays as arguments.
	 *
	 * @param array $diffs (variadic) Input array(s)
	 * @access public
	 */
	public function __construct(array ... $diffs)
	{
		$this->diff = $diffs;
	}

	/**
	 * Return the master diff result object and calculates
	 * the different result types
	 *
	 * @return DiffResult
	 */
	public function results()
	{
		$changes = [];

		for($i = 0; $i < count($this->diff) -1; ++$i)
		{
			$first = $i;
			$second = $i + 1;
			$label = $first . '::' . $second;

			$keys = array_merge(array_keys($this->diff[$first]), array_keys($this->diff[$second]));
			$keys = array_values(array_unique($keys));

			foreach($keys as $key)
			{
				if(array_key_exists($key, $this->diff[$first]) && array_key_exists($key, $this->diff[$second]) && $this->diff[$first][$key] != $this->diff[$second][$key])
				{
					$changes[$label][] = [
						'key' => $key,
						'action' => self::ALTERED,
						'sets' => [
							$first => $this->diff[$first][$key],
							$second => $this->diff[$second][$key]
						]
					];
				}

				if(array_key_exists($key, $this->diff[$first]) && !array_key_exists($key, $this->diff[$second]))
				{
					$changes[$label][] = [
						'key' => $key,
						'action' => self::REMOVED,
						'sets' => [
							$first => $this->diff[$first][$key],
							$second => null
						]
					];
				}

				if(!array_key_exists($key, $this->diff[$first]) && array_key_exists($key, $this->diff[$second]))
				{
					$changes[$label][] = [
						'key' => $key,
						'action' => self::ADDED,
						'sets' => [
							$first => null,
							$second => $this->diff[$second][$key]
						]
					];
				}
			}

			return new DiffResult($changes);
		}
	}
}
