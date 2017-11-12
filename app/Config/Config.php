<?php

namespace Glue\App\Config;

class Config
{
	protected $plugin = null;
	
	protected $config = [];

	public function __construct($plugin)
	{
		$this->plugin = $plugin;
		$this->config = include $plugin->basePath('/config/app.php');
	}

	public function get($key = null, $default = null)
	{
		if (!$key) {
			return $this->config;
		} else {
			return isset($this->config[$key]) ? $this->config[$key] : $default;
		}
	}

	public function set($key, $value)
	{
		$this->config[$key] = $value;
		return $this;
	}

	public function __get($key = null)
	{
		return $this->get($key);
	}

	public function __set($key, $value)
	{
		return $this->set($key, $value);
	}
}