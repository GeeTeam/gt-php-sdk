<?php
namespace GeeTeam\Geetest\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Geetest extends Facade
{

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'geetest';
	}
}