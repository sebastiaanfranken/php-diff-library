<?php

/**
 * Handles and manages the (massive) output from the Diff class
 *
 * @author Sebastiaan Franken <sebastiaan@sebastiaanfranken.nl>
 */

namespace Sfranken;

class DiffResult
{
	/**
	 * The output result from the Diff class is used
	 * as input here
	 *
	 * @access protected
	 * @var array
	 */
	protected $diff = [];

	/**
	 * Sets the Diff class output as the $diff variable
	 * defined above.
	 *
	 * @param array $diff The Diff class output
	 * @access public
	 */
	public function __construct(array $diff)
	{
		$this->diff = $diff;
	}

	/**
	 * Returns the $diff array as-is
	 *
	 * @access public
	 * @return array
	 */
	public function toArray()
	{
		return $this->diff;
	}

	/**
	 * Returns an array with every item that matches
	 * the action provided.
	 *
	 * @param string $action The action you want to filter for
	 * @param bool $withSets Only show labels, or include entire
	 * 						 change sets as well
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
		return $this->getAction(Diff::ALTERED, $withSets);
	}

	/**
	 * Return all items that are ADDED
	 *
	 * @param bool $withSets return with or without changesets?
	 * @access public
	 * @return array
	 * @see getAction
	 */
	public function getAdded()
	{
		return $this->getAction(Diff::ADDED, $withSets);
	}

	/**
	 * Return all items that are REMOVED
	 *
	 * @param bool $withSets return with or without changesets?
	 * @access public
	 * @return array
	 * @see getAction
	 */
	public function getRemoved()
	{
		return $this->getAction(Diff::REMOVED, $withSets);
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
