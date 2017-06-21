<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Coupon;

/**
 * Class Base
 * @package CouponModule\Database
 */
abstract class Base
{
    /**
     * Base constructor.
     */
    protected function __construct()
    {
    }

    /**
     * @return Database
     */
    protected function DB()
    {
        return Coupon::getInstance()->getDatabase();
    }
}
