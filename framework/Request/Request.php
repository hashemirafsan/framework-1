<?php

namespace GlueNamespace\Framework\Request;

class Request
{
	protected $get = [];
	protected $post = [];
	protected $request = [];
	protected $app = null;
	
	public function __construct($app, $get, $post)
	{
		$this->app = $app;
		$this->request = array_merge(
			$this->get = $this->clean($get),
			$this->post = $this->clean($post)
		);
	}

	public function clean($request)
	{
		$clean = [];
		foreach ($request as $key => $value) {
			$key = trim(stripslashes($key));
			$clean[$key] = is_array($value) ? $this->clean($value) : $this->trimAndStrip($value);
		}
		return $clean;
	}

	public function trimAndStrip($value)
	{
		return trim(stripslashes($value));
	}

	public function set($key, $value)
	{
		$this->request[$key] = $value;
		return $this;
	}

	public function all()
	{
		return $this->get();
	}

	public function get($key = null, $default = null)
	{
		if (!$key) {
			return $this->request;
		} else {
			return isset($this->request[$key]) ? $this->request[$key] : $default;
		}
	}

	public function query($key = null)
	{
		return $key ? $this->get[$key] : $this->get;
	}

	public function post($key = null)
	{
		return $key ? $this->post[$key] : $this->post;
	}

	public function only($args)
	{
		$values = [];
		$keys = is_array($args) ? $args : func_get_args();
		foreach ($keys as $key) {
			$values[$key] = @$this->request[$key];
		}
		return $values;
	}

	public function except($args)
	{
		$values = [];
		$keys = is_array($args) ? $args : func_get_args();
		foreach ($this->request as $key => $value) {
			if (!in_array($key, $keys)) {
				$values[$key] = $this->request[$key];
			}
		}
		return $values;
	}

	public function merge(array $data = [])
	{
		$this->request = array_merge($this->request, $data);
		return $this;
	}
}
