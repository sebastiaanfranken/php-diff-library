<?php

/**
 * Compare a number of arrays and return the differences, like a
 * Git diff
 *
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */

namespace Sfranken;

class Diff
{

	/*
	 * The following thee constants (ADDED, REMOVED, ALTERED) are used to denote one or more of the following things:
	 * - added items
	 * - removed items
	 * - altered items
	 */
	const ADDED = 'ADDED';
	const REMOVED = 'REMOVED';
	const ALTERED = 'ALTERED';

	/**
	 * The resulting diff (array)
	 *
	 * @access protected
	 * @var array
	 */
	protected $diff = [];

	/**
	 * Create a new Diff class instance with a variable number
	 * or arguments, thanks to PHP's splat operator.
	 *
	 * @param array $changes Input array(s)
	 * @access public
	 */
	public function __construct(array ... $changes)
	{
		for($i = 0; $i < count($changes) - 1; ++$i)
		{
			$first = $i;
			$second = $i + 1;
			$label = $first . '::' . $second;
			$keys = array_merge(array_keys($changes[$first]), array_keys($changes[$second]));
			$keys = array_values(array_unique($keys));

			foreach($keys as $key)
			{
				if(array_key_exists($key, $changes[$first]) && array_key_exists($key, $changes[$second]) && $changes[$first][$key] != $changes[$second][$key])
				{
					$this->diff[$label][] = [
						'key' => $key,
						'action' => self::ALTERED,
						'sets' => [
							$first => $changes[$first][$key],
							$second => $changes[$second][$key]
						]
					];
				}

				if(array_key_exists($key, $changes[$first]) && !array_key_exists($key, $changes[$second]))
				{
					$this->diff[$label][] = [
						'key' => $key,
						'action' => self::REMOVED,
						'sets' => [
							$first => $changes[$first][$key],
							$second => null
						]
					];
				}

				if(!array_key_exists($key, $changes[$first]) && array_key_exists($key, $changes[$second]))
				{
					$this->diff[$label][] = [
						'key' => $key,
						'action' => self::ADDED,
						'sets' => [
							$first => null,
							$second => $changes[$second][$key]
						]
					];
				}
			}
		}
	}

	/**
	 * Returns the $diff array
	 *
	 * @return array
	 * @access public
	 */
	public function toArray()
	{
		return $this->diff;
	}

	/**
	 * Returns the $diff array as an object
	 *
	 * @return object
	 * @access public
	 * @see toJSON()
	 */
	public function toObject()
	{
		return (object)json_decode($this->toJSON());
	}

	/**
	 * Returns the $diff array as a JSON object
	 *
	 * @return object
	 * @access public
	 */
	public function toJSON()
	{
		return json_encode($this->diff);
	}

	/**
	 * Getter for the raw diff data array
	 *
	 * @return array
	 * @access public
	 */
	public function getDiff()
	{
		return $this->diff;
	}

	/**
	 * Setter for a new diff array
	 *
	 * @param array $newdiff The new diff data
	 * @return Sfranken\Diff
	 * @access public
	 */
	public function setDiff(array ... $diff)
	{
		$this->diff = $diff;
		return $this;
	}

	/**
	 * Append the array $append onto our $diff array
	 *
	 * @param array $append The new array to append
	 * @return Sfranken\Diff
	 * @access public
	 */
	public function appendDiff(array $append)
	{
		$this->diff[] = $append;
		return $this;
	}

	/**
	 * Returns an array with every item in $diff that matches
	 * the provided action
	 *
	 * @param string $action The action to match
	 * @param bool $withSets include changesets or not?
	 * @access public
	 * @return array
	 */
	public function getAction($action, $withSets = true)
	{
		$results = [];

		foreach($this->diff as $delta => $changes)
		{
			foreach($changes as $change)
			{
				if($change['action'] == $action)
				{
					if($withSets == true)
					{
						$results[$delta][$change['key']] = array_values($change['sets']);
					}
					else
					{
						$results[$delta][] = $change['key'];
					}
				}
			}
		}

		return $results;
	}

	/**
	 * Return all items that are ALTERED
	 *
	 * @param bool $withSets return with or without changesets?
	 * @access public
	 * @return array
	 * @see getAction
	 */
	public function getAltered($withSets = true)
	{
		return $this->getAction(self::ALTERED, $withSets);
	}

	/**
	 * Return all items that are ADDED
	 *
	 * @param bool $withSets return with or without changesets?
	 * @access public
	 * @return array
	 * @see getAction
	 */
	public function getAdded($withSets = true)
	{
		return $this->getAction(self::ADDED, $withSets);
	}

	/**
	 * Return all items that are REMOVED
	 *
	 * @param bool $withSets return with or without changesets?
	 * @access public
	 * @return array
	 * @see getAction
	 */
	public function getRemoved($withSets = true)
	{
		return $this->getAction(self::REMOVED, $withSets);
	}

	/**
	 * Gets a single action from the diff array
	 *
	 * @param string $delta The change delta address (x::y)
	 * @param int $change The specific change child
	 * @param string $field A specific child field
	 * @access public
	 * @return mixed
	 */
	public function getSingle($delta, $change, $field = null)
	{
		return is_null($field) ? $this->diff[$delta][$change] : $this->diff[$delta][$change][$field];
	}
}
