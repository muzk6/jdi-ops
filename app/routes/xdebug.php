<?php

/**
 * XDebug
 */

/**
 * 主页
 */
route_get('/xdebug/index', function () {
    $files = glob(PATH_OPS_TRACE . '/*.xt');
    $expire = strtotime('-2 hours');
    $data = [];

    foreach ($files as $file) {
        $mtime = filemtime($file);
        if ($mtime < $expire) { // 删除过期文件
            unlink($file);
            continue;
        }

        $basename = basename($file);
        $filename = base64_decode(str_replace(['-', '_'], ['+', '/'], rtrim($basename, '.xt')));
        $trace_data = json_decode($filename, true);

        $data[] = [
            'name' => $basename,
            'mtime_ts' => $mtime,
            'mtime' => date('Y-m-d H:i:s', $mtime),
            'trace' => $trace_data['trace'],
            'user_id' => $trace_data['user_id'] ?: '',
            'url' => $trace_data['url'],
        ];
    }

    usort($data, function ($a, $b) {
        return $b['mtime_ts'] - $a['mtime_ts'];
    });

    return view('xdebug/index', ['data' => $data]);
});

/**
 * 监听页面
 */
route_get('/xdebug/listen', function () {
    $load_conf = function () use (&$load_conf) {
        $trace_conf = [
            'url' => '',
            'name' => '',
            'user_id' => '',
            'expire_second' => 120,
            'max_depth' => 0,
            'max_data' => 0,
            'max_children' => 0,
        ];

        $trace_conf_file = PATH_OPS_TRACE . '/.tracerc';
        if (file_exists($trace_conf_file)) {
            $trace_conf = array_merge($trace_conf, include($trace_conf_file));

            // 已过期
            if ($trace_conf['expire'] <= time()) {
                unlink($trace_conf_file);
                return $load_conf();
            }

            $trace_conf['en'] = 1;
        } else {
            $trace_conf['en'] = 0;
            $trace_conf['max_depth'] = intval(ini_get('xdebug.var_display_max_depth'));
            $trace_conf['max_data'] = intval(ini_get('xdebug.var_display_max_data'));
            $trace_conf['max_children'] = intval(ini_get('xdebug.var_display_max_children'));
        }

        return $trace_conf;
    };

    $trace_conf = $load_conf();

    return view('xdebug/listen', ['trace_conf' => $trace_conf]);
});

/**
 * 监听设置
 */
route_post('/xdebug/listen', function () {
    $url = validate('url')->required()->get('URL ');
    $name = input('name');
    $user_id = input('user_id');
    $expire_second = validate('expire_second:i')->numeric()->lte(600)->get('过期秒数');
    $max_depth = validate('max_depth:i')->numeric()->get('Max Depth ');
    $max_data = validate('max_data:i')->numeric()->get('Max Data ');
    $max_children = validate('max_children:i')->numeric()->get('Max Children ');

    $trace_conf_file = PATH_OPS_TRACE . '/.tracerc';

    $conf = [
        'url' => $url,
        'name' => $name,
        'user_id' => $user_id,
        'expire' => $expire_second + time(),
        'expire_second' => $expire_second,
        'max_depth' => $max_depth,
        'max_data' => $max_data,
        'max_children' => $max_children,
    ];

    file_put_contents($trace_conf_file, "<?php\nreturn " . var_export($conf, true) . ";\n");

    return api_msg('监听开启');
});

/**
 * 关闭监听
 */
route_post('/xdebug/close', function () {
    $trace_conf_file = PATH_OPS_TRACE . '/.tracerc';
    is_file($trace_conf_file) && unlink($trace_conf_file);

    return api_msg('监听关闭');
});