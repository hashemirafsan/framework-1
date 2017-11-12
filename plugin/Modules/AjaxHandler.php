<?php

namespace Glue\Plugin\Modules;

use Glue\Request;

class AjaxHandler
{
	public function handle()
	{
		wp_send_json(Request::all());
	}
}