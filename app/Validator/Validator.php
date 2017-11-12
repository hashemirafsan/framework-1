<?php

namespace Glue\App\Validator;

class Validator
{
	protected $plugin = null;

	public function __construct($plugin)
	{
		$this->plugin = $plugin;
	}
}