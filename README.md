# jdi-ops
> JDI 框架的 OPS 运维后台，用于运维监控与开发调试，包括 日志、调试、性能分析

## 起步

- `git clone --depth=1 https://github.com/muzk6/jdi-ops.git` 克隆项目
- 进去上面克隆的项目，`composer install --no-dev` 安装依赖
- 复制 `env.example.php` 为 `env.php`, 配置里面的常量
- http 服务配置入口目录为 `public/`

*注意：如果提示目录权限错误，需要对 `data` 目录(没有则自己新建)加上写权限*

## 其它可选

### XHProf

GUI - View Full Callgraph 功能，需要安装 `graphviz`

- Ubuntu: `sudo apt install graphviz`
- CentOS: `yum install graphviz`