<?php

namespace Glue\App\Foundation;

use Glue\App\Exception\UnResolveableEntityException;

Abstract class BaseAlias
{
	static $instance = null;

	public static function setApplicationInstance($instance)
	{
		static::$instance = $instance;
	}

    public static function __callStatic($method, $params)
	{
		return call_user_func_array([
			static::$instance->make(static::$key), $method
		], $params);
	}
}
