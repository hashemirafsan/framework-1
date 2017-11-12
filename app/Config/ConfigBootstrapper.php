<?php

namespace Glue\App\Config;

class ConfigBootstrapper
{
	public function booting($plugin)
	{
		$plugin->bind('config', new Config($plugin), 'Config');
	}
}