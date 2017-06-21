# coupon-module

## 当前版本

[![Latest Stable Version](https://img.shields.io/packagist/v/windomz/coupon-module.svg?style=flat-square)](https://packagist.org/packages/windomz/coupon-module)
[![Build Status](https://img.shields.io/travis/WindomZ/coupon-module/master.svg?style=flat-square)](https://travis-ci.org/WindomZ/coupon-module)

## 运行环境

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.0-8892BF.svg?style=flat-square)](https://php.net/)
[![Minimum MYSQL Version](https://img.shields.io/badge/mysql-%3E%3D%205.6-4479a1.svg?style=flat-square)](https://www.mysql.com/)

## 安装与更新

```bash
$ composer require windomz/coupon-module
```

## 使用用法

### 配置文件

创建并编写`config.yml`，里面参数根据您的环境情况修改：
```yaml
database_host: 127.0.0.1
database_port: 3306
database_type: mysql
database_name: coupondb
database_username: root
database_password: root
database_logging: true
```

如果只是作为测试，可以在`MySQL`运行`./sql/coupondb.sql`来快速创建测试数据库。

在项目初始化阶段，**加载**指定配置文件：
```php
Coupon::setConfigPath('./config.yml');
```

### 模块定义

- 优惠卷活动(`CouponActivity`): 方便管理优惠卷的发放
- 优惠卷模板(`CouponTemplate`): 方便管理优惠卷的样式
- 优惠卷包(`CouponPack`): 方便统一生成优惠卷
- 优惠卷批次(`CouponBatch`): 方便标记指定用户优惠卷批次
- 优惠卷(`Coupon`): 指定用户的优惠卷

### 业务流程

- 后台：优惠卷活动(`CouponActivity`) -> 优惠卷模板(`CouponTemplate`) -> 优惠卷包(`CouponPack`)
- 业务：优惠卷包(`CouponPack`) -> 优惠卷批次(`CouponBatch`) -> 优惠卷(`Coupon`)

### 属性字段

#### 优惠卷活动(`CouponActivity`)

|类型|字段|必填|修改|描述|
|---|---|:---:|:---:|---|
|string|id|N|N|UUID|
|string|post_time|N|N|创建时间|
|string|put_time|N|N|修改时间|
|string|name|Y|Y|名称|
|bool|active|N|Y|是否生效|
|string|level|N|Y|级别|
|string|desc|N|Y|描述|
|string|url|N|Y|链接地址|
|int|class|Y|N|类别(第一级分类，单选，可选)，采用分类方式：0, 1, 2, 3, 4, 5, 6, 7...|
|int|kind|Y|N|类型(第二级分类，多选，可选)，采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|int|coupon_limit|Y|Y|用户优惠卷派放次数限制，为0则不限制|
|string|dead_time|Y|Y|截止时间|

#### 优惠卷模板(`CouponTemplate`)

|类型|字段|必填|修改|描述|
|---|---|:---:|:---:|---|
|string|id|N|N|UUID|
|string|post_time|N|N|创建时间|
|string|put_time|N|N|修改时间|
|string|name|Y|Y|名称|
|bool|active|N|Y|是否生效|
|string|level|N|Y|级别|
|string|desc|N|Y|描述|
|int|class|Y|N|类别(第一级分类，单选，可选)，采用分类方式：0, 1, 2, 3, 4, 5, 6, 7...|
|int|kind|Y|N|类型(第二级分类，多选，可选)，采用分类方式：1, 2, 4, 8, 16, 32, 64...|
|string|product_id|N|N|关联商品UUID(第二级分类，单选，可选)|
|float|min_amount|Y|N|满减条件金额|
|float|offer_amount|Y|N|满减金额|

#### 优惠卷包(`CouponPack`)

|类型|字段|必填|修改|描述|
|---|---|:---:|:---:|---|
|string|id|N|N|UUID|
|string|post_time|N|N|创建时间|
|string|put_time|N|N|修改时间|
|string|name|Y|Y|名称|
|bool|active|N|Y|是否生效|
|string|level|N|Y|级别|
|string|desc|N|Y|描述|
|string|activity_id|Y|N|活动UUID|
|string|template_id|Y|N|优惠卷模板UUID|
|int|coupon_size|Y|Y|优惠卷派放总数|
|int|coupon_count|N|N|优惠卷派放数量|
|string|dead_time|Y|Y|截止时间|

#### 优惠卷批次(`CouponBatch`)

|类型|字段|必填|修改|描述|
|---|---|:---:|:---:|---|
|string|id|N|N|UUID|
|string|post_time|N|N|创建时间|
|string|put_time|N|N|修改时间|
|string|owner_id|Y|N|用户UUID|
|string|activity_id|Y|N|活动UUID|

#### 优惠卷(`Coupon`)

|类型|字段|必填|修改|描述|
|---|---|:---:|:---:|---|
|string|id|N|N|UUID|
|string|post_time|N|N|创建时间|
|string|put_time|N|N|修改时间|
|string|name|Y|Y|名称|
|bool|active|N|Y|是否生效|
|string|level|N|Y|级别|
|string|desc|N|Y|描述|
|string|owner_id|Y|N|用户UUID|
|string|activity_id|Y|N|活动UUID|
|string|template_id|Y|N|优惠卷模板UUID|
|int|used_count|N|N|优惠卷使用次数|
|string|used_time|N|N|优惠卷使用时间|
|int|class|Y|N|类别(第一级分类，单选，可选)，同`CouponTemplate`|
|int|kind|Y|N|类型(第二级分类，多选，可选)，同`CouponTemplate`|
|string|product_id|N|N|关联商品UUID(第二级分类，单选，可选)，同`CouponTemplate`|
|float|min_amount|Y|N|满减条件金额|
|float|offer_amount|Y|N|满减金额|
|string|dead_time|Y|Y|截止时间|

### 接口方法

#### 优惠卷活动(`CouponActivity`)

- CouponActivity::object($id)
  - @description 查询优惠卷活动(`CouponActivity`)
  - @param
    - string $id 优惠卷活动UUID
  - @return object

- CouponActivity::create($name, $desc, $coupon_limit)
  - @description 构建优惠卷活动(`CouponActivity`)
  - @param
    - string $name 名称
    - string $desc 描述
    - int $coupon_limit 优惠卷派放次数限制
  - @return object

- CouponActivity::list($where, $limit, $page, $order)
  - @description 获取一组优惠卷活动(`CouponActivity`)
  - @param
    - array $where 筛选范围，选用`CouponActivity::COL_`开头的字段
    - int $limit 筛选数量
    - int $page 筛选页数
    - array $order 筛选排序
  - @return array

- CouponActivity->post()
  - @description 创建优惠卷活动(`CouponActivity`)
  - @return bool

- CouponActivity->put($columns)
  - @description 修改优惠卷活动(`CouponActivity`)
  - @param
    - array $columns 标明修改的字段，选用`CouponActivity::COL_`开头的字段组成数组
  - @return bool

- CouponActivity->disable()
  - @description 取消优惠卷活动(`CouponActivity`)
  - @param
  - @return bool

#### 优惠卷模板(`CouponTemplate`)

- CouponTemplate::object($id)
  - @description 查询优惠卷模板(`CouponTemplate`)
  - @param
    - string $id 优惠卷模板UUID
  - @return object

- CouponTemplate::create($name, $desc, $min_amount, $offer_amount)
  - @description 构建优惠卷模板(`CouponTemplate`)
  - @param
    - string $name 名称
    - string $desc 描述
    - float $min_amount 满减条件金额
    - float $offer_amount 满减金额
  - @return object

- CouponTemplate::list($where, $limit, $page, $order)
  - @description 获取一组优惠卷模板(`CouponTemplate`)
  - @param
    - array $where 筛选范围，选用`CouponTemplate::COL_`开头的字段
    - int $limit 筛选数量
    - int $page 筛选页数
    - array $order 筛选排序
  - @return array

- CouponTemplate->post()
  - @description 创建优惠卷模板(`CouponTemplate`)
  - @return bool

- CouponTemplate->put($columns)
  - @description 修改优惠卷模板(`CouponTemplate`)
  - @param
    - array $columns 标明修改的字段，选用`CouponTemplate::COL_`开头的字段组成数组
  - @return bool

- CouponTemplate->disable()
  - @description 取消优惠卷模板(`CouponTemplate`)
  - @param
  - @return bool

#### 优惠卷包(`CouponPack`)

- CouponPack::object($id)
  - @description 查询优惠卷包(`CouponPack`)
  - @param
    - string $id 优惠卷包UUID
  - @return object

- CouponPack::create($name, $desc, $activity_id, $template_id, $coupon_size)
  - @description 构建优惠卷包(`CouponPack`)
  - @param
    - string $name 名称
    - string $desc 描述
    - string $activity_id 活动UUID
    - string $template_id 优惠卷模板UUID
    - int $coupon_size 优惠卷派放总数
  - @return object

- CouponPack::list($where, $limit, $page, $order)
  - @description 获取一组优惠卷包(`CouponPack`)
  - @param
    - array $where 筛选范围，选用`CouponPack::COL_`开头的字段
    - int $limit 筛选数量
    - int $page 筛选页数
    - array $order 筛选排序
  - @return array

- CouponPack->post()
  - @description 创建优惠卷包(`CouponPack`)
  - @return bool

- CouponPack->put($columns)
  - @description 修改优惠卷包(`CouponPack`)
  - @param
    - array $columns 标明修改的字段，选用`CouponPack::COL_`开头的字段组成数组
  - @return bool

- CouponPack->disable()
  - @description 取消优惠卷包(`CouponPack`)
  - @param
  - @return bool

#### 优惠卷批次(`CouponBatch`)

- CouponBatch::object($id)
  - @description 查询优惠卷批次(`CouponBatch`)
  - @param
    - string $id 优惠卷批次UUID
  - @return object

- CouponBatch::create($owner_id, $activity_id)
  - @description 构建优惠卷批次(`CouponBatch`)
  - @param
    - string $owner_id 用户UUID
    - string $activity_id 优惠卷活动UUID
  - @return object

- CouponBatch::list($where, $limit, $page, $order)
  - @description 获取一组优惠卷批次(`CouponBatch`)
  - @param
    - array $where 筛选范围，选用`CouponBatch::COL_`开头的字段
    - int $limit 筛选数量
    - int $page 筛选页数
    - array $order 筛选排序
  - @return array

- CouponBatch->post()
  - @description 创建优惠卷批次(`CouponBatch`)
  - @return bool

- CouponBatch->put($columns)
  - @description 修改优惠卷批次(`CouponBatch`)
  - @param
    - array $columns 标明修改的字段，选用`CouponBatch::COL_`开头的字段组成数组
  - @return bool

#### 优惠卷(`Coupon`)

- Coupon::object($id)
  - @description 查询优惠卷(`Coupon`)
  - @param
    - string $id 优惠卷UUID
  - @return object

- Coupon::create($owner_id, $pack_id, $batch_id)
  - @description 构建优惠卷(`Coupon`)
  - @param
    - string $owner_id 用户UUID
    - string $pack_id 优惠卷包UUID
    - string $batch_id 优惠卷批次UUID
  - @return object

- Coupon::list($where, $limit, $page, $order)
  - @description 获取一组优惠卷(`Coupon`)
  - @param
    - array $where 筛选范围，选用`Coupon::COL_`开头的字段
    - int $limit 筛选数量
    - int $page 筛选页数
    - array $order 筛选排序
  - @return array

- Coupon->post()
  - @description 创建优惠卷(`Coupon`)
  - @return bool

- Coupon->put($columns)
  - @description 修改优惠卷(`Coupon`)
  - @param
    - array $columns 标明修改的字段，选用`Coupon::COL_`开头的字段组成数组
  - @return bool

- Coupon->disable()
  - @description 取消优惠卷(`Coupon`)
  - @param
  - @return bool

- Coupon->use()
  - @description 使用优惠卷(`Coupon`)
  - @param
  - @return bool

#### 优惠卷管理(`CouponManager`)

- CouponManager::clean()
  - @description 注销所有过期的优惠卷活动(`CouponActivity`)/优惠卷包(`CouponPack`)/优惠卷(`Coupon`)
  - @return array 注销个数

#### 公共方法

- *->toJSON()
  - @description 转为JSON格式对象
  - @demo `$obj->toJSON()`
  - @return object

- *::where($type, $key)
  - @description 使用`*::list($where, $limit, $page, $order)`时，构造`$where`的高级用法。
  - @demo `[Coupon::where(Coupon::WHERE_GTE, Coupon::COL_USED_COUNT) => 10]`，等同于`[Coupon::COL_USED_COUNT>=10]`。
  - @param
    - int $type 对象
    - string $key 对象
  - @return object
