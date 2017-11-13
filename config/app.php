<?php

return array(
	'plugin_name' => '',
	'plugin_slug' => '',
	'plugin_uri' => '',
	'plugin_version' => '',
	'author_name' => '',
	'author_email' => '',
	'author_uri' => '',

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