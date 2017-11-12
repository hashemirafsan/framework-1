<?php

namespace Glue\App\Foundation;

use Glue\App\Foundation\Application;

class Bootstrap
{
	protected $config = null;
	protected $baseDir = null;
	protected $baseFile = null;
	protected $autoload = null;
	protected $namespace = null;
	protected $namespaceMapping = null;

	public static function boot($baseFile)
	{
		return new static($baseFile);
	}

	public function __construct($baseFile)
	{
		$this->baseFile = $baseFile;
		$this->baseDir = dirname($baseFile).'/';
		$this->validatePlugin() && $this->registerLoader();
		return new Application($baseFile, $this->config);
	}

	public function validatePlugin()
	{
		if(!file_exists($file = $this->baseDir.'config/app.php')) {
	        die('The [config.php] file is missing from "'.$this->baseDir.'" directory.');
	    }

	    $this->config = include $file;
	    if (!($this->autoload = @$this->config['autoload'])) {
	        die('The [autoload] is not specified or invalid in "'.$file.'" file.');
	    }

	    if (!$this->namespace = @$this->autoload['namespace']) {
	        die('The [namespace] is not specified or invalid in "'.$file.'" file.');
	    }

	    $this->namespaceMapping = @$this->autoload['mapping'];
	    if (!$this->namespaceMapping || empty((array)$this->namespaceMapping)) {
	        die('The [mapping] is not specified or invalid "'.$file.'" file.');
	    }

	    return true;
	}

	public function registerLoader()
	{
		spl_autoload_register([$this, 'loader']);
	}

	public function loader($class)
	{
		$len = strlen($this->namespace);
		if(substr($class, 0, $len) !== $this->namespace) {
			return;
		}
		
        foreach ($this->namespaceMapping as $key => $value) {
        	$className = str_replace(
        		array('\\', $key, $this->namespace),
        		array('/', $value, ''),
        		$class
        	);

            $file = $this->baseDir.trim($className, '/').'.php';
            
            if (isset($file) && is_readable($file)) {
	            return include $file;
	        }
        }
	}
}