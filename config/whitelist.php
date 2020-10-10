<?php

/**
 * 白名单
 */

return [
    // 支持网络号位数格式，例如 0.0.0.0/0 表示所有 IP
    'ip' => WHITELIST_IP,
    // 请求时带上白名单 Cookie. 判断逻辑为 isset($_COOKIE[...])
    'cookie' => WHITELIST_COOKIE,
    'user_id' => [
    ],
];