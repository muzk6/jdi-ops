# jdi-ops
> JDI 框架的 OPS 运维后台，用于运维监控与开发调试，包括 日志、调试、性能分析

- `git clone https://github.com/muzk6/jdi-ops.git` 克隆项目
- 复制 `env.example.php` 为 `env.php`, 配置里面的常量
- 配置入口目录为 `public/` 的 http 服务，参考下面 Nginx 配置：

```conf
server {
    listen 80;
    server_name jdi-ops.com
    root /www/jdi-ops/public;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
        index index.php index.html index.htm;
    }

    location ~ \.php$ {
        try_files $uri /index.php =404;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```