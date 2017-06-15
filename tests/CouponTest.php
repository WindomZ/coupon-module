<?php declare(strict_types=1);

namespace CouponModule\Test;

use CouponModule\Coupon;

use PHPUnit\Framework\TestCase;

class CouponTest extends TestCase
{
    /**
     * @covers  Coupon::getInstance()
     * @return Coupon
     */
    public function testNewCoupon()
    {
        Coupon::setConfigPath('./tests/config.yml');
        $coupon = Coupon::getInstance();
        self::assertNotEmpty($coupon);

        self::assertEquals($coupon->getConfig()->get('database_host'), '127.0.0.1');
        self::assertEquals($coupon->getConfig()->get('database_port'), 3306);
        self::assertEquals($coupon->getConfig()->get('database_type'), 'mysql');
        self::assertEquals($coupon->getConfig()->get('database_name'), 'coupondb');
        self::assertEquals($coupon->getConfig()->get('database_username'), 'root');
        self::assertEquals($coupon->getConfig()->get('database_password'), 'root');
        self::assertEquals($coupon->getConfig()->get('database_logging'), true);
        self::assertEquals($coupon->getConfig()->get('database_prefix'), 'cp_');

        return $coupon;
    }
}
