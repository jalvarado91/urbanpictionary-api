<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Word
 * @package App
 */
class Word extends Model
{
	/**
	 * @var string
	 */
	private $term;

	/**
	 * @var string
	 */
	private $definition;

	/**
	 * @var string
	 */
	private $letters;

	/**
	 * @var string
	 */
	private $gifs;

	protected $fillable = ['term', 'definition', 'letters', 'gifs'];
}
