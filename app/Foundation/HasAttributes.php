<?php

namespace Glue\App\Foundation;

trait HasAttributes
{
	public function getBaseFile()
	{
		return $this->baseFile;
	}

	public function getNamespace()
	{
		return $this->settings['autoload']['namespace'];
	}

	public function getPluginSettings()
	{
		return $this->settings;
	}

    public function __get($key)
	{
		return $this->make($key);
	}

    public function offsetGet($offset)
    {
        return $this->make($offset);
    }

    public function offsetExists($offset)
    {
    	$c = static::$container;
    	$s = static::$singletons;
        return isset($c[$offset]) || isset($s[$offset]);
    }

	final public function offsetUnset($offset)
    {
        // FORBIDDEN!!!
    }

	final public function __set($key, $value)
	{
		// FORBIDDEN!!!
	}

	final public function offsetSet($offset, $value)
    {
        // FORBIDDEN!!!
    }
}