<?php

namespace GlueNamespace\Framework\Foundation;

abstract class Provider
{
	protected $app = null;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public abstract function booting();
	
	public function booted()
	{
		// ...
	}
}