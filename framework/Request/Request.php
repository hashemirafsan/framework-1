<?php

namespace GlueNamespace\Framework\Request;

use GlueNamespace\Framework\Foundation\Application;

class Request
{
	protected $app = null;
	protected $headers = array();
	protected $server = array();
	protected $cookie = array();
	protected $json = array();
	protected $get = array();
	protected $post = array();
	protected $request = array();
	
	public function __construct($app, $get, $post)
	{
		$this->app = $app;
		$this->server = $_SERVER;
		$this->cookie = $_COOKIE;
		$this->request = array_merge(
			$this->get = $this->clean($get),
			$this->post = $this->clean($post)
		);
	}

	public function clean($request)
	{
		$clean = [];
		foreach ($request as $key => $value) {
			$key = trim(strip_tags(stripslashes($key)));
			$clean[$key] = is_array($value) ? $this->clean($value) : $this->trimAndStrip($value);
		}
		return $clean;
	}

	public function trimAndStrip($value)
	{
		return trim(strip_tags(stripslashes($value)));
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

	public function server($key = null)
	{
		return $key ? $this->server[$key] : $this->server;
	}

	public function header($key = null)
	{
		if (!$this->headers) {
			$this->headers = $this->setHeaders();
		}

		return $key ? $this->headers[$key] : $this->headers;
	}

	public function cookie($key = null)
	{
		return $key ? $this->cookie[$key] : $this->cookie;
	}

	public function json($key = null)
    {
		if (!$this->json) {
			$this->json = json_decode(
				file_get_contents('php://input'), TRUE
			);
		}

		return $key ? $this->json[$key] : $this->json;
    }

	/**
	 * Taken and modified from Symfony
	 */
	public function setHeaders()
    {
        $headers = array();
        $parameters = $this->server;
        $contentHeaders = array('CONTENT_LENGTH' => true, 'CONTENT_MD5' => true, 'CONTENT_TYPE' => true);
        foreach ($parameters as $key => $value) {
            if (0 === strpos($key, 'HTTP_')) {
                $headers[substr($key, 5)] = $value;
            }
            // CONTENT_* are not prefixed with HTTP_
            elseif (isset($contentHeaders[$key])) {
                $headers[$key] = $value;
            }
        }

        if (isset($parameters['PHP_AUTH_USER'])) {
            $headers['PHP_AUTH_USER'] = $parameters['PHP_AUTH_USER'];
            $headers['PHP_AUTH_PW'] = isset($parameters['PHP_AUTH_PW']) ? $parameters['PHP_AUTH_PW'] : '';
        } else {
            /*
             * php-cgi under Apache does not pass HTTP Basic user/pass to PHP by default
             * For this workaround to work, add these lines to your .htaccess file:
             * RewriteCond %{HTTP:Authorization} ^(.+)$
             * RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
             *
             * A sample .htaccess file:
             * RewriteEngine On
             * RewriteCond %{HTTP:Authorization} ^(.+)$
             * RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
             * RewriteCond %{REQUEST_FILENAME} !-f
             * RewriteRule ^(.*)$ app.php [QSA,L]
             */

            $authorizationHeader = null;
            if (isset($parameters['HTTP_AUTHORIZATION'])) {
                $authorizationHeader = $parameters['HTTP_AUTHORIZATION'];
            } elseif (isset($parameters['REDIRECT_HTTP_AUTHORIZATION'])) {
                $authorizationHeader = $parameters['REDIRECT_HTTP_AUTHORIZATION'];
            }

            if (null !== $authorizationHeader) {
                if (0 === stripos($authorizationHeader, 'basic ')) {
                    // Decode AUTHORIZATION header into PHP_AUTH_USER and PHP_AUTH_PW when authorization header is basic
                    $exploded = explode(':', base64_decode(substr($authorizationHeader, 6)), 2);
                    if (count($exploded) == 2) {
                        list($headers['PHP_AUTH_USER'], $headers['PHP_AUTH_PW']) = $exploded;
                    }
                } elseif (empty($parameters['PHP_AUTH_DIGEST']) && (0 === stripos($authorizationHeader, 'digest '))) {
                    // In some circumstances PHP_AUTH_DIGEST needs to be set
                    $headers['PHP_AUTH_DIGEST'] = $authorizationHeader;
                    $parameters['PHP_AUTH_DIGEST'] = $authorizationHeader;
                } elseif (0 === stripos($authorizationHeader, 'bearer ')) {
                    /*
                     * XXX: Since there is no PHP_AUTH_BEARER in PHP predefined variables,
                     *      I'll just set $headers['AUTHORIZATION'] here.
                     *      http://php.net/manual/en/reserved.variables.server.php
                     */
                    $headers['AUTHORIZATION'] = $authorizationHeader;
                }
            }
        }

        if (isset($headers['AUTHORIZATION'])) {
            return $headers;
        }

        // PHP_AUTH_USER/PHP_AUTH_PW
        if (isset($headers['PHP_AUTH_USER'])) {
            $headers['AUTHORIZATION'] = 'Basic '.base64_encode($headers['PHP_AUTH_USER'].':'.$headers['PHP_AUTH_PW']);
        } elseif (isset($headers['PHP_AUTH_DIGEST'])) {
            $headers['AUTHORIZATION'] = $headers['PHP_AUTH_DIGEST'];
        }

        return $headers;
    }
}
