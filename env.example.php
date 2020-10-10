<?php

define('PATH_OPS_LOG', '/your_project/data/log'); // 目标项目 —— 日志目录
define('PATH_OPS_TRACE', '/your_project/data/xdebug_trace'); // 目标项目 —— Xdebug Trace 目录
define('PATH_OPS_XHPROF', '/your_project/data/xhprof'); // 目标项目 —— XHProf 记录目录
define('LOGIN_PASSWD', ''); // 登录密码，不能为空
define('WHITELIST_IP', ['0.0.0.0/0']);  // 访问白名单 IP (IP, Cookie 设置其中一个即可，注意生产环境要设置成指定值)
define('WHITELIST_COOKIE', []); // 访问白名单 Cookie