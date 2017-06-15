<?php declare(strict_types=1);

namespace CouponModule\Model;

use CouponModule\Database\CouponActivity as DbCouponActivity;
use CouponModule\Exception\ErrorException;

/**
 * Class CouponActivity
 * @package CouponModule\Model
 */
class CouponActivity extends DbCouponActivity
{
    /**
     * CouponActivity constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return CouponActivity
     */
    protected function newObject()
    {
        return new CouponActivity();
    }

    /**
     * @param string|null $id
     * @return CouponActivity|null
     */
    public static function object(string $id = null)
    {
        $obj = new CouponActivity();
        if ($id && !$obj->getById($id)) {
            return null;
        }

        return $obj;
    }

    /**
     * @param string $name
     * @param string $desc
     * @param int $coupon_limit
     * @param string $dead_time
     * @return CouponActivity
     * @throws ErrorException
     */
    public static function create(
        string $name,
        string $desc = '',
        int $coupon_limit = 0,
        string $dead_time = ''
    ) {
        if (empty($name)) {
            throw new ErrorException('"name" should not be empty: '.$name);
        }

        $obj = new CouponActivity();
        $obj->name = $name;
        $obj->desc = $desc;
        $obj->coupon_limit = $coupon_limit;
        $obj->dead_time = $dead_time;

        return $obj;
    }

    /**
     * @param array|null $where
     * @param int $limit
     * @param int $page
     * @param array|null $order
     * @return array|null
     */
    public static function list(array $where = null, int $limit = 0, int $page = 0, array $order = null)
    {
        return (new CouponActivity())->select($where, $limit, $page, $order);
    }

    /**
     * @return bool
     */
    public function pass()
    {
        return $this->active;
    }

    /**
     * @return bool
     * @throws ErrorException
     */
    public function disable(): bool
    {
        $this->active = false;

        return $this->put([self::COL_ACTIVE]);
    }
}
