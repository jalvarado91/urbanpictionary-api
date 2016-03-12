<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Word
 * @package App
 */
class Word extends Model
{
	private $term;
	private $definition;
	private $letters;
	private $gifs;

	/**
	 * @return string
	 */
	public function getTerm()
	{
		return $this->term;
	}

	/**
	 * @param string $term
	 */
	public function setTerm($term)
	{
		$this->term = $term;
	}

	/**
	 * @return string
	 */
	public function getDefinition()
	{
		return $this->definition;
	}

	/**
	 * @param string $definition
	 */
	public function setDefinition($definition)
	{
		$this->definition = $definition;
	}

	/**
	 * @return string
	 */
	public function getLetters()
	{
		return $this->letters;
	}

	/**
	 * @param string $letters
	 */
	public function setLetters($letters)
	{
		$this->letters = $letters;
	}

	/**
	 * @return string
	 */
	public function getGifs()
	{
		return $this->gifs;
	}

	/**
	 * @param string $gifs
	 */
	public function setGifs($gifs)
	{
		$this->gifs = $gifs;
	}
}
