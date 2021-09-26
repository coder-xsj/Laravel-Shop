#### Laravel-Shop 项目
> 用于学习

开发分成以下几个模块
1. 舞台布置
2. 用户模块
   - [x] 注册
   - [x] 登录
   - [x] 邮箱验证
   - [x] 新建收货地址
   - [x] 修改收货地址
   - [x] 删除收货地址
3. 管理后台
   - [x] encore/laravel-admin
   - [x] 用户列表
   - [x] 权限设置
4. 商品模块
   - [x] 后台商品列表
   - [x] 商品创建
   - [x] 商品编辑
   - [ ] 前台商品列表
   - [ ] 前台商品排序、筛选
   - [ ] 前台商品详情页
   - [ ] 前台商品收藏
   - [ ] 前台商品收藏列表
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

然后今天访问了老半天的 `larabbs.test`， 说怎么一直无法响应，还搜了半天 phpStudy 部署 laravel8 无法访问

今天被一个 `.default` 给坑了
app.js 引入 vue 组件 得加上 `.default`
```
window.Vue = require('vue').default;
```

然后在 `js/components/SelectDistrict.js` 的 `$emit` 方法 方括号位置没打对
```
this.$emit('change', [this.provinces[this.provinceId], this.cities[this.cityId], this.districts[this.districtId]]);
```
写成
```
this.$emit('change', [this.provinces[this.provinceId]], this.cities[this.cityId], this.districts[this.districtId]);
```

2021-9-25 0:18

今天开发完 地址列表与添加

2021-9-25
14:07
开发完 收货地址的 增删改查
