<?php

define('PATH_ROOT', __DIR__);
define('PATH_ROUTES', PATH_ROOT . '/app/routes');

if (file_exists(__DIR__ . '/env.php')) {
    include __DIR__ . '/env.php';

    array_map(function ($path) {
        if ($path && !file_exists($path)) {
            mkdir($path, 0744, true);
        }
    }, [PATH_OPS_LOG, PATH_OPS_TRACE, PATH_OPS_XHPROF]);
}

require PATH_ROOT . '/vendor/autoload.php';

// 框架初始化
\JDI\App::init([
    'config.debug' => false,
    'config.path_data' => PATH_ROOT . '/data',
    'config.path_view' => PATH_ROOT . '/views',
    'config.path_config_first' => PATH_ROOT . '/config',
]);