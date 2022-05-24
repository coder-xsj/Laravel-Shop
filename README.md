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
   - [x] 前台商品列表
   - [x] 前台商品排序、筛选
   - [x] 前台商品详情页
   - [x] 优雅的处理异常
   - [x] 前台商品收藏
   - [x] 前台商品收藏列表
5. 购物车 & 订单模块
   - [x] 商品加入到购物车
   - [x] 查看购物车
   - [x] 订单数据模型
   - [x] 购物车下单页面
   - [x] 关闭未支付订单
   - [ ] 用户订单列表
   - [ ] 用户订单详情页
6. 支付模块
    - [ ] 集成支付宝
    - [ ] 订单支付功能
    - [ ] 集成 Ngrok 反向代理
    - [ ] 支付宝服务端回调
    - [ ] 集成微信支付
    - [ ] 订单的微信支付
7. 完善订单模块
    - [ ] 管理后台 - 订单列表
    - [ ] 管理后台 - 订单详情
    - [ ] 管理后台 - 订单发货
    - [ ] 管理后台 - 确认收货
    - [ ] 管理后台 - 评价商品
    - [ ] 用户界面 - 申请退款
    - [ ] 管理后台 - 拒绝退款
    - [ ] 管理后台 - 同意退款（支付宝）
    - [ ] 管理后台 - 同意退款（微信）
8. 优惠券模块
   - [ ] 管理后台 - 优惠券列表
   - [ ] 管理后台 - 添加优惠券
   - [ ] 管理后台 - 修改和删除优惠券
   - [ ] 用户界面 - 检查优惠券
   - [ ] 用户界面 - 使用优惠券下单

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

2021-9-27 2:22
开发完 后台编辑商品，前台商品列表页面，筛选、排序、前台详情页、处理异常
今天遇到一个坑，就是修改商品上传图片时候无法显示图片
从 console 报错地址来看是
```
shop.test/storage/images/iPone13.jpn
```
也差了一下确实是在这个文件夹下，但是死活就是不行
然后考虑到这个 `storage` 是通过 `php artisan storage:links` 命令创建的软链接
然后我在页面直接修改地址为原来的`storage/app/public/images/iPone13.jpg` 但还是无法显示
后台根据别人的错误原因
1. `.env` 文件中 `APP_URL` 得和访问域名一致
2. `config/admin.php` 中的 `upload.disk` 得设置成 `public`

检查如下

原因 1
```
APP_URL=http://shop.test
```
我觉得没毛病的

原因 2
```
   'disk' => 'public',
```
也没有问题

后来我说是不是没加 www
然后试了一下把 `APP_URL` 设置为如下
```
APP_URL=http://www.shop.test
```
然后图片就显示出来了，果然啊。。。

总结：
1. 今天对于 `筛选和排序` 那块的代码不是很理解
2. 用法啥的根本想不起来了，得多应用
3. 想法 --- 自定义 404 页面

> 毕业了 2022/5/24 22:20 重新开始

关闭未支付订单这个模块，需要开启 `redis`，但是一提交订单之后 `closed` 字段马上就被置位 `1`，也就是一下单就会被关闭。 

![closeOrder](https://s2.loli.net/2022/05/24/oJ71v3xW8Y9iDjm.gif)

经仔细检查，发现是时间写错

![image-20220524225532880](https://s2.loli.net/2022/05/24/gQGMOExSNuR4BqK.png)

![image-20220524225609845](https://s2.loli.net/2022/05/24/KbZRSI83VLCtA2z.png)

![image-20220524225624102](https://s2.loli.net/2022/05/24/UsEVuq2IGjzm34l.png)