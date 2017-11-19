<?php

namespace GlueNamespace\Framework\Foundation;

trait PathsAndUrlsTrait
{
	public function baseFile()
	{
		return $this->baseFile;
	}

	public function path($path = '')
	{
		return $this['path'].ltrim($path, '/');
	}

	public function appPath($path = '')
	{
		return $this['path.app'].ltrim($path, '/');
	}

	public function configPath($path = '')
	{
		return $this['path.config'].ltrim($path, '/');
	}

	public function frameworkPath($path = '')
	{
		return $this['path.framework'].ltrim($path, '/');
	}

	public function resourcePath($path = '')
	{
		return $this['path.resource'].ltrim($path, '/');
	}

	public function languagePath($path = '')
	{
		return $this['path.language'].ltrim($path, '/');
	}

	public function storagePath($path = '')
	{
		return $this['path.storage'].ltrim($path, '/');
	}

	public function viewPath($path = '')
	{
		return $this['path.view'].ltrim($path, '/');
	}

	public function assetPath($path = '')
	{
		return $this['path.asset'].ltrim($path, '/');
	}

	public function publicPath($path = '')
	{
		return $this['path.public'].ltrim($path, '/');
	}

	public function url($url = '')
	{
		return $this['url'].ltrim($url, '/');
	}

	public function publicUrl($url = '')
	{
		return $this['url.public'].ltrim($url, '/');
	}

	public function resourceUrl($url = '')
	{
		return $this['url.resource'].ltrim($url, '/');
	}

	public function assetUrl($url = '')
	{
		return $this['url.asset'].ltrim($url, '/');
	}
}
