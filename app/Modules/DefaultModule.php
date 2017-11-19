<?php

namespace GlueNamespace\App\Modules;

use GlueNamespace\App;

class DefaultModule
{
	public function handle()
	{
		wp_send_json(App::make('config')->all());
	}
}