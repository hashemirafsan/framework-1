<?php

namespace GlueNamespace\Framework\Config;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use GlueNamespace\Framework\Foundation\Provider;

class ConfigProvider extends Provider
{
    /**
     * The provider booting method to boot this provider
     * @return void
     */
	public function booting()
    {
        $this->app->bindInstance('config', new Config, 'Config', Config::class);
    }

    /**
     * The provider booted method to be called after booting
     * @return void
     */
    public function booted()
    {
        $this->loadConfig();
    }

    /**
     * Loads all configuration files from config directory
     * @return void
     */
	public function loadConfig()
    {
    	$files = [];
        $configPath = $this->app->configPath();
        $itr = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(
            $configPath,RecursiveDirectoryIterator::SKIP_DOTS
        ));

        $this->app->config->set('app', $this->app->getAppConfig());

        foreach($itr as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == "php" && $file->getFileName() != 'app.php') {
                $fileRealPath = $file->getRealPath();
                $directory = $this->getDirectory($file, $configPath);
                $files[$directory.basename($fileRealPath, '.php')] = $fileRealPath;
            }
        }
        
        foreach ($files as $key => $path) {
            $this->app->config->set($key, include $path);
        }
    }

    /**
     * Get nested directory names joined by a "."
     * @param  string $file [A config file]
     * @param  string $configPath
     * @return string
     */
    protected function getDirectory($file, $configPath)
    {
        $ds = DIRECTORY_SEPARATOR;

        if ($directory = trim(str_replace(trim($configPath, '/'), '', $file->getPath()), $ds)) {
            $directory = str_replace($ds, '.', $directory).'.';
        }

        return $directory;
    }
}