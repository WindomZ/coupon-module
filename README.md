# coupon-module

> A coupon module component - modularity and easy to deploy.

[![Latest Stable Version](https://img.shields.io/packagist/v/windomz/coupon-module.svg?style=flat-square)](https://packagist.org/packages/windomz/coupon-module)
[![Build Status](https://img.shields.io/travis/WindomZ/coupon-module/master.svg?style=flat-square)](https://travis-ci.org/WindomZ/coupon-module)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Minimum MYSQL Version](https://img.shields.io/badge/mysql-%3E%3D%205.6-4479a1.svg?style=flat-square)](https://www.mysql.com/)
[![Platform](https://img.shields.io/badge/platform-Linux%2FmacOS%2FWindows-ff69b4.svg?style=flat-square)](#readme)

[中文文档](https://github.com/WindomZ/coupon-module/blob/master/README_Ch-zh.md#readme)

## Feature

- [x] CouponActivity
- [x] CouponTemplate
- [x] CouponPack = CouponActivity + CouponTemplate
- [x] CouponBatch
- [x] Coupon = CouponPack + CouponBatch

## Install

Open the terminal in the project directory:
```bash
$ composer require windomz/coupon-module
```

Create a configuration file, like `config.yml`:
```yaml
database_host: 127.0.0.1
database_port: 3306
database_type: mysql
database_name: coupondb
database_username: root
database_password: root
database_logging: true # open debug log
```

If only for quick testing, 
you can run `./sql/coupondb.sql` in `MySQL` to quickly create a test database.

Of course, you can also customize the `database name` based on `./sql/coupondb.sql`, 
but note that the `table name` _CANNOT MODIFY_!

In the project initialization code, 
load the specified configuration file through the following implementation:
```php
Coupon::setConfigPath('./config.yml');
```

## Usage

Refer to the [Document](https://windomz.github.io/coupon-module)(_Currently only Chinese_) for details.

## License

[MIT](https://github.com/WindomZ/coupon-module/blob/master/LICENSE)
