# coupon-module

> 一个优惠券模块组件 - 模块化且易部署

[![Latest Stable Version](https://img.shields.io/packagist/v/windomz/coupon-module.svg?style=flat-square)](https://packagist.org/packages/windomz/coupon-module)
[![Build Status](https://img.shields.io/travis/WindomZ/coupon-module/master.svg?style=flat-square)](https://travis-ci.org/WindomZ/coupon-module)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Minimum MYSQL Version](https://img.shields.io/badge/mysql-%3E%3D%205.6-4479a1.svg?style=flat-square)](https://www.mysql.com/)
[![Platform](https://img.shields.io/badge/platform-Linux%2FmacOS%2FWindows-ff69b4.svg?style=flat-square)](#readme)

[English](https://github.com/WindomZ/coupon-module/blob/master/README.md#readme)

## 特性

- [x] 优惠券活动
- [x] 优惠券模板
- [x] 优惠券包 = 优惠券活动 + 优惠券模板
- [x] 优惠券批次
- [x] 优惠券 = 优惠券包 + 优惠券批次

## 安装

在项目目录中打开终端：
```bash
$ composer require windomz/coupon-module
```

创建一个配置文件，比如`config.yml`：
```yaml
database_host: 127.0.0.1
database_port: 3306
database_type: mysql
database_name: coupondb
database_username: root
database_password: root
database_logging: true
```

如果仅用于快速测试，
您可以在`MySQL`中运行`./sql/coupondb.sql`来快速创建一个测试数据库。

当然，您也可以根据`./sql/coupondb.sql`自定义`database name`，
但是请注意`table name`_不能改动_！

在项目初始化代码中，
通过以下实现加载指定的配置文件：
```php
Coupon::setConfigPath('./config.yml');
```

## 用法

有关详细信息，请参阅[文档](https://windomz.github.io/coupon-module)。

## 许可

[MIT](https://github.com/WindomZ/coupon-module/blob/master/LICENSE)
