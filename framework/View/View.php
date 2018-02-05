<?php

namespace GlueNamespace\Framework\View;

class View
{
    protected $app = null;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function make($path, $data = [])
    {
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        $file = $this->app->viewPath($path).'.php';
        if (file_exists($file)) {
            ob_start();
            extract($data);
            include $file;
            return ob_get_clean();
        }

        throw new \InvalidArgumentException("The view file [$file] doesn't exists!");
    }

    public function render($path, $data = [])
    {
        echo $this->make($path, $data);
    }
}