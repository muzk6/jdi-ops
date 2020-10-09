<?php

define('PATH_ROOT', __DIR__);
define('PATH_ROUTES', PATH_ROOT . '/app/routes');

require PATH_ROOT . '/vendor/autoload.php';

// 框架初始化
\JDI\App::init([
    'config.app_env' => 'pub', // 当前环境；dev 时回显错误信息
    'config.path_config_first' => PATH_ROOT . '/config/dev', // 第一优先级配置目录，找不到配置文件时，就在第二优先级配置目录里找
    'config.path_config_second' => PATH_ROOT . '/config/common', // 第二优先级配置目录
    'config.path_view' => PATH_ROOT . '/views', // 视图模板目录
    'config.path_data' => PATH_ROOT . '/data', // 数据目录
    'config.init_handler' => null, // 容器初始化回调，为空时默认调用 \JDI\App::initHandler
]);

if (file_exists(__DIR__ . '/env.php')) {
    include __DIR__ . '/env.php';

    array_map(function ($path) {
        if ($path && !file_exists($path)) {
            mkdir($path, 0744, true);
        }
    }, [PATH_OPS_LOG, PATH_OPS_TRACE, PATH_OPS_XHPROF]);
}