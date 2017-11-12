<?php

namespace Glue\App\Request;

class RequestBootstrapper
{
	public function booting($plugin)
	{
		$plugin->bindSingleton('request', function($plugin) {
			return new Request($plugin, $_GET, $_POST);
		}, 'Request');
	}
}