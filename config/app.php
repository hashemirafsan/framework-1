<?php

return array(
	'env' => 'dev',
	'providers' => array(
		'core' => array(
			GlueNamespace\Framework\Foundation\AppProvider::class,
			GlueNamespace\Framework\Config\ConfigProvider::class,
			GlueNamespace\Framework\Request\RequestProvider::class,
			GlueNamespace\Framework\View\ViewProvider::class,
			GlueNamespace\Framework\FileSystem\FileSystemProvider::class,
		),

		'plugin' => array(
			'common' => array(
				GlueNamespace\App\Providers\CommonProvider::class,
				GlueNamespace\App\Providers\FormBuilderProvider::class,
			),

			'backend' => array(
				GlueNamespace\App\Providers\BackendProvider::class,
			),

			'frontend' => array(
				GlueNamespace\App\Providers\FrontendProvider::class,
			),
		),
	),
);
