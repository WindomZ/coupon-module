<?php declare(strict_types=1);

namespace CouponModule\Model;

use CouponModule\Database\Base;
use CouponModule\Exception\ErrorException;
use CouponModule\Util\Date;

/**
 * Class CouponManager
 * @package CouponModule\Model
 */
class CouponManager extends Base
{
    /**
     * @var CouponManager
     */
    private static $_instance;

    private function __clone()
    {
    }

    /**
     * @return CouponManager
     */
    public static function getInstance(): CouponManager
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new CouponManager();
        }

        return self::$_instance;
    }

    /**
     * @return int
     * @throws ErrorException
     */
    private static function cleanCouponActivity()
    {
        $query = self::getInstance()->DB()->update(
            CouponActivity::TABLE_NAME,
            [CouponActivity::COL_ACTIVE => false],
            [
                CouponActivity::where(
                    CouponActivity::WHERE_LTE,
                    CouponActivity::COL_DEAD_TIME
                ) => Date::get_now_time(),
            ]
        );
        if ($query->errorCode() !== '00000') {
            throw new ErrorException($query->errorInfo()[2]);
        }

        return $query->rowCount();
    }

    /**
     * @return int
     * @throws ErrorException
     */
    private static function cleanCouponPack()
    {
        $query = self::getInstance()->DB()->update(
            CouponPack::TABLE_NAME,
            [CouponPack::COL_ACTIVE => false],
            [
                CouponPack::where(
                    CouponPack::WHERE_LTE,
                    CouponPack::COL_DEAD_TIME
                ) => Date::get_now_time(),
            ]
        );
        if ($query->errorCode() !== '00000') {
            throw new ErrorException($query->errorInfo()[2]);
        }

        return $query->rowCount();
    }

    /**
     * @return int
     * @throws ErrorException
     */
    private static function cleanCoupon()
    {
        $query = self::getInstance()->DB()->update(
            Coupon::TABLE_NAME,
            [Coupon::COL_ACTIVE => false],
            [
                Coupon::where(
                    Coupon::WHERE_LTE,
                    Coupon::COL_DEAD_TIME
                ) => Date::get_now_time(),
            ]
        );
        if ($query->errorCode() !== '00000') {
            throw new ErrorException($query->errorInfo()[2]);
        }

        return $query->rowCount();
    }

    /**
     * @return array
     * @throws ErrorException
     */
    public static function clean()
    {
        return [
            'CouponActivity' => self::cleanCouponActivity(),
            'CouponPack' => self::cleanCouponPack(),
            'Coupon' => self::cleanCoupon(),
        ];
    }
}
