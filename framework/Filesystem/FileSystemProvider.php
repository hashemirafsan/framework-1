<?php

namespace GlueNamespace\Framework\FileSystem;

use GlueNamespace\Framework\Foundation\Provider;

class FileSystemProvider extends Provider
{
	/**
     * The provider booting method to boot this provider
     * @return void
     */
	public function booting()
	{
		$this->app->bindSingleton('fs', function($app) {
			return new FileSystem($app);
		}, 'FS');
	}
}
