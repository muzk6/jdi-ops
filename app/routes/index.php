<?php

/**
 * OPS 主页
 */

route_middleware(function () {
    // 白名单以外直接 404
    if (!(svc_whitelist()->isSafeIp() || svc_whitelist()->isSafeCookie())) {
        http_response_code(404);
        exit;
    }
});

/**
 * 主页
 */
route_get('/', function () {
    if (!svc_auth()->isLogin()) {
        redirect('/index/login');
    }

    return view('index');
});

/**
 * 登录页
 */
route_get('/index/login', function () {
    if (svc_auth()->isLogin()) {
        redirect('/');
    }

    return view('login');
});

/**
 * 登录
 */
route_post('/index/login', function () {
    $passwd = validate('post.passwd')->required()->get('密码');
    if (!LOGIN_PASSWD || $passwd !== LOGIN_PASSWD) {
        return api_error('密码错误');
    }

    svc_auth()->login('ops');

    return api_success();
});

/**
 * 退出登录
 */
route_any('/index/logout', function () {
    svc_auth()->logout();
    redirect('/index/login');
});

route_group(function () {
    route_middleware(function () {
        if (!svc_auth()->isLogin()) {
            redirect('/index/login');
        }
    });

    include PATH_ROUTES . '/log.php';
    include PATH_ROUTES . '/xdebug.php';
});