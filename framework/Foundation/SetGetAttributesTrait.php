<?php

namespace GlueNamespace\Framework\Foundation;

trait SetGetAttributesTrait
{
	public function __get($key)
	{
		return $this->make($key);
	}

	public function __set($key, $value)
	{
	    $this[$key] = $value;
	}

	public function getBaseFile()
	{
		return $this->baseFile;
	}

	public function getAppConfig()
	{
		return $this->appConfig;
	}

	public function getProviders($type = null)
	{
		$providers = $this->getAppConfig()['providers'];
		
		return $type ? $providers[$type] : $providers;
	}

	public function getName()
	{
		return $this->getAppConfig()['plugin_name'];
	}

	public function getSlug()
	{
		return $this->appConfig['plugin_slug'];
	}

	public function getVersion()
	{
		return $this->appConfig['plugin_version'];
	}

	public function getNamespace()
	{
		return $this->getAppConfig()['autoload']['namespace'];
	}

	public function getTextDomain()
	{
		return $this->appConfig['plugin_text_domain']
		? $this->appConfig['plugin_text_domain']
		: $this->appConfig['plugin_slug'];
	}

	public function getEnv()
	{
		if (isset($this->getAppConfig()['env'])) {
			return $this->getAppConfig()['env'];
		}
	}
}