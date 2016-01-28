<?php

/**
 * Compare the differences (diff) between two array's or datasets
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
	 * The main "alpha" array
	 *
	 * @access protected
	 * @var array
	 */
	protected $a = [];

	/**
	 * The main "beta" array
	 *
	 * @access protected
	 * @var array
	 */
	protected $b = [];

	/**
	 * Creates a new Diff class instance with a "alpha" and "beta" values
	 *
	 * @param array $alpha The "alpha" array
	 * @param array $beta The "beta" array
	 * @access public
	 */
	public function __construct(array $alpha, array $beta)
	{
		$this->a = $alpha;
		$this->b = $beta;
		$this->diff = [];

		$keys = array_merge(array_keys($this->a), array_keys($this->b));
		$keys = array_unique($keys);
		$keys = array_values($keys);

		foreach($keys as $key)
		{
			if(array_key_exists($key, $this->a) && array_key_exists($key, $this->b) && $this->a[$key] != $this->b[$key])
			{
				$this->diff[] = [
					'key' => $key,
					'alpha' => $this->a[$key],
					'beta' => $this->b[$key],
					'action' => self::ALTERED
				];
			}

			if(array_key_exists($key, $this->a) && !array_key_exists($key, $this->b))
			{
				$this->diff[] = [
					'key' => $key,
					'alpha' => $this->a[$key],
					'beta' => null,
					'action' => self::REMOVED
				];
			}

			if(!array_key_exists($key, $this->a) && array_key_exists($key, $this->b))
			{
				$this->diff[] = [
					'key' => $key,
					'alpha' => null,
					'beta' => $this->b[$key],
					'action' => self::ADDED
				];
			}
		}
	}

	/**
	 * Return the complete diff as an array
	 *
	 * @return array
	 * @access public
	 */
	public function toArray()
	{
		return (array)$this->diff;
	}

	/**
	 * Return the complete diff as an object
	 *
	 * @return object
	 * @access public
	 */
	public function toObject()
	{
		return (object)json_decode($this->toJSON());
	}

	/**
	 * Return the complete diff as a JSON object
	 *
	 * @return object
	 * @access public
	 */
	public function toJSON()
	{
		return json_encode($this->diff);
	}

	/**
	 * Get the main key field from the diff array
	 *
	 * @param int $id The specific diff key
	 * @return string|false
	 * @access public
	 */
	public function getKey($id)
	{
		return (array_key_exists($id, $this->diff) && array_key_exists('key', $this->diff[$id])) ? $this->diff[$id]['key'] : false;
	}

	/**
	 * Get all 'key' fields from the diff array
	 *
	 * @return array
	 * @access public
	 */
	public function getKeys()
	{
		$out = [];

		foreach($this->diff as $diff)
		{
			if(array_key_exists('key', $diff))
			{
				$out[] = $diff['key'];
			}
		}

		return $out;
	}

	/**
	 * Get the main 'alpha' field from the diff array
	 *
	 * @param int $id The specific diff key
	 * @return string|false
	 * @access public
	 */
	public function getAlpha($id)
	{
		return (array_key_exists($id, $this->diff) && array_key_exists('alpha', $this->diff[$id])) ? $this->diff[$id]['alpha'] : false;
	}

	/**
	 * Return all 'alpha' keys from the diff result
	 *
	 * @access public
	 * @return array
	 */
	public function getAlphas()
	{
		$out = [];

		foreach($this->diff as $diff)
		{
			if(array_key_exists('alpha', $diff))
			{
				$out[] = $diff['alpha'];
			}
		}

		return $out;
	}

	/**
	 * Get the main 'beta' field from the diff result
	 *
	 * @param int $id The specific diff key
	 * @return string|false
	 * @access public
	 */
	public function getBeta($id)
	{
		return (array_key_exists($id, $this->diff) && array_key_exists('beta', $this->diff[$id])) ? $this->diff[$id]['beta'] : false;
	}

	/**
	 * Return all 'beta' keys from the diff result
	 *
	 * @access public
	 * @return array
	 */
	public function getBetas()
	{
		$out = [];

		foreach($this->diff as $diff)
		{
			if(array_key_exists('beta', $diff))
			{
				$out[] = $diff['beta'];
			}
		}

		return $out;
	}

	/**
	 * Get the main 'action' field from the diff array
	 *
	 * @param int $id The specific diff key
	 * @return string|false
	 * @access public
	 */
	public function getAction($id)
	{
		return (array_key_exists($id, $this->diff) && array_key_exists('action', $this->diff[$id])) ? $this->diff[$id]['action'] : false;
	}

	/**
	 * Return all 'action' keys from the diff result
	 *
	 * @access public
	 * @return array
	 */
	public function getActions()
	{
		$out = [];

		foreach($this->diff as $diff)
		{
			if(array_key_exists('action', $diff))
			{
				$out[] = $diff['action'];
			}
		}

		return $out;
	}

	/**
	 * Return all "altered" items from the diff result
	 *
	 * @access public
	 * @return array
	 */
	public function getAltered()
	{
		$out = [];

		foreach($this->diff as $diff)
		{
			if(array_key_exists('action', $diff) && $diff['action'] == self::ALTERED)
			{
				$out[] = $diff;
			}
		}

		return $out;
	}

	/**
	 * Returns all "removed" items from the diff result
	 *
	 * @access public
	 * @return array
	 */
	public function getRemoved()
	{
		$out = [];

		foreach($this->diff as $diff)
		{
			if(array_key_exists('action', $diff) && $diff['action'] == self::REMOVED)
			{
				$out[] = $diff;
			}
		}

		return $out;
	}

	/**
	 * Returns all "added" items from the diff result
	 *
	 * @access public
	 * @return array
	 */
	public function getAdded()
	{
		$out = [];

		foreach($this->diff as $diff)
		{
			if(array_key_exists('action', $diff) && $diff['action'] == self::ADDED)
			{
				$out[] = $diff;
			}
		}

		return $diff;
	}

	/**
	 * Getter for the "a" array
	 *
	 * @return array
	 * @access public
	 */
	public function getA()
	{
		return $this->a;
	}

	/**
	 * Setter for the "a" array
	 *
	 * @param array $alpha The new "a" array
	 * @return Diff
	 */
	public function setA(array $alpha)
	{
		$this->a = $alpha;
		return $this;
	}

	/**
	 * Getter for the "b" array
	 *
	 * @return array
	 * @access public
	 */
	public function getB()
	{
		return $this->b;
	}

	/**
	 * Setter for the "b" array
	 *
	 * @param array $beta The new "b" array
	 * @return Diff
	 */
	public function setB(array $bravo)
	{
		$this->b = $bravo;
		return $this;
	}
}
