<?php

return [
    'env'       => 'dev',
    'providers' => [
        'core' => [
            'GlueNamespace\Framework\Foundation\AppProvider',
            'GlueNamespace\Framework\Config\ConfigProvider',
            'GlueNamespace\Framework\Request\RequestProvider',
            'GlueNamespace\Framework\View\ViewProvider',
        ],

        'plugin' => [
            'common' => [
                'GlueNamespace\App\Providers\CommonProvider',
            ],

            'backend' => [
                'GlueNamespace\App\Providers\BackendProvider',
            ],

            'frontend' => [
                'GlueNamespace\App\Providers\FrontendProvider',
            ],
        ],
    ],
];
