<?php

return array(
	'plugin_name' => 'The Glue',
	'plugin_slug' => 'glue',
	'plugin_uri' => 'http://glue.com',
	'plugin_version' => '1.0.0',
	'author_name' => 'Sheikh Heera',
	'author_email' => 'heera.sheikh77@gmail.com',
	'author_uri' => 'http://heera.it',

	'autoload' => array(
		'namespace' => 'Glue',
		'mapping' => array(
			'App' => 'app',
			'Plugin' => 'plugin'
		)
	),

	'providers' => array(
		'core' => array(
			Glue\App\Foundation\AppBootstrapper::class,
			Glue\App\Config\ConfigBootstrapper::class,
			Glue\App\Request\RequestBootstrapper::class,
			Glue\App\FileSystem\FileSystemBootstrapper::class,
			Glue\App\Validator\ValidatorBootstrapper::class,
			Glue\App\View\ViewBootstrapper::class,
		),

		'plugin' => array(
			'common' => array(
				Glue\Plugin\Providers\Common::class,
			),

			'backend' => array(
				Glue\Plugin\Providers\Backend::class,
			),

			'frontend' => array(
				Glue\Plugin\Providers\Frontend::class,
			),
		),
	),
);