## SSO 统一认证系统

    - 前台 + 后台的方案
    - 支持自定义Guard 驱动认证方式 （支持非Laravel 内置的加密体系）
    - 支持jwt 单点token 登录方式，自动失效之前token
    - 后台基于Laravel
    - 前台基于【Vue-Element-Admin】脚手架进行开发
    - 后台支持回调平台登录（三方免密登录）这个就是约定的加密解密认证，需要自定义Guard 认证用户体系
    - 跳转平台给予同主域名的Cookie 方式进行登录给予token 的共享名单

## 系统环境

PHP 7.3

MYSQL: 8.0

Laravel: 8+

Redis: 支持单机版 + 集群方式（database.php 已注释）


系统使用JWT 配合 Cookie  方式生成的一套SSO 登录系统
