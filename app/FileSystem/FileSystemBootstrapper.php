<?php

namespace Glue\App\FileSystem;

class FileSystemBootstrapper
{
	public function booting($plugin)
	{
		$plugin->bind('fs', function($plugin) {
			return new FileSystem($plugin);
		}, 'FS');
	}
}