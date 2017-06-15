# coupon-module

> Developing...

[![Latest Stable Version](https://img.shields.io/packagist/v/windomz/coupon-module.svg?style=flat-square)](https://packagist.org/packages/windomz/coupon-module)
[![Build Status](https://img.shields.io/travis/WindomZ/coupon-module/master.svg?style=flat-square)](https://travis-ci.org/WindomZ/coupon-module)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Minimum MYSQL Version](https://img.shields.io/badge/mysql-%3E%3D%205.6-4479a1.svg?style=flat-square)](https://www.mysql.com/)

## Feature

- [x] CouponActivity
- [x] CouponTemplate
- [x] CouponPack = CouponActivity + CouponTemplate
- [x] Coupon = one of CouponPack

## Installation

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
database_logging: true
```

If only for quick testing, 
you can run `./sql/coupondb.sql` in `MySQL` to quickly create a test database_

Of course, you can also customize the `database name` based on `./sql/coupondb.sql`, 
but note that the `table name` can not be _MODIFIED_!

In the project initialization, 
load the specified configuration file through the following implementation:
```php
Coupon::setConfigPath('./config.yml');
```

## Usage

Refer to the [Document](https://windomz.github.io/coupon-module)(_Currently only Chinese_) for details.

## License

The [MIT License](https://github.com/WindomZ/coupon-module/blob/master/LICENSE)
