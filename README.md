#### Laravel-Shop 项目
> 用于学习

开发分成以下几个模块
1. 舞台布置
2. 用户模块
   - [x] 注册
   - [x] 登录
   - [x] 邮箱
3. 管理后台
4. 商品模块
5. 购物车 & 订单模块
6. 支付模块
7. 完善订单模块
8. 优惠券模块

> 目前进行到 第一步 --- 2021-9-23
>  
> 卡到 npm 模块安装了


win10 + phpStudy + laravel8 报错


一条命令解决了 --- 打开了无数个标签页
```
npm i vue-loader
```
但是还是有些报错的 --- 但是不影响

2021-9-24 0:45
开发完 登录与注册 功能

解决了 nginx 中除首页外都不能访问问题
```bash
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

遇到 `maillog` 我没有
1. 下载 Windows for docker
2. 配置 docker 下载镜像
3. 安装 maillog
```dockerfile
docker run --name mailhog -p 1025:1025 -p 8025:8025 -d mailhog/mailhog
```
