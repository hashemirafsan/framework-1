<?php

return array(
	'env' => 'dev',
	'providers' => array(
		'core' => array(
			'GlueNamespace\Framework\Foundation\AppProvider',
			'GlueNamespace\Framework\Config\ConfigProvider',
			'GlueNamespace\Framework\Request\RequestProvider',
			'GlueNamespace\Framework\View\ViewProvider',
			'GlueNamespace\Framework\FileSystem\FileSystemProvider',
		),

		'plugin' => array(
			'common' => array(
				'GlueNamespace\App\Providers\CommonProvider',
			),

			'backend' => array(
				'GlueNamespace\App\Providers\BackendProvider',
			),

			'frontend' => array(
				'GlueNamespace\App\Providers\FrontendProvider',
			),
		),
	),
);
