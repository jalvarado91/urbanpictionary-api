<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Word
 * @package App
 */
class Word extends Model
{
	protected $fillable = ['term', 'definition', 'letters', 'gifs'];

	public function getLettersAttribute($value) {
		return unserialize($value);
	}

	public function setLettersAttribute($value) {
		$this->attributes['letters'] = serialize($value);
	}

	public function getGifsAttribute($value) {
		return unserialize($value);
	}

	public function setGifsAttribute($value) {
		$this->attributes['gifs'] = serialize($value);
	}
}
