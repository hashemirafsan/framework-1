<?php

namespace GlueNamespace\Framework\Foundation;

class HookReference
{
	private $ref = null;

	public function __construct(Application $app, $ref, $key = null)
	{
		$this->app = $app;
		$this->ref = $ref;
		$this->key = $key;
	}

	public function saveReference($key = null)
	{
		// TODO: Add exception
		$this->app->bindInstance($key ? $key : $this->key, $this->ref);

		return $this->ref;
	}

	public function reference()
	{
		return $this->ref;
	}
}