<?php

namespace Glue\App\Validator;

class ValidatorBootstrapper
{
	public function booting($plugin)
	{
		$plugin->bind('validator', function($plugin) {
			return new Validator($plugin);
		}, 'Validator');
	}
}