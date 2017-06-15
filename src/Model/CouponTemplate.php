<?php declare(strict_types=1);

namespace CouponModule\Model;

use CouponModule\Database\CouponTemplate as DbCouponTemplate;
use CouponModule\Exception\ErrorException;

/**
 * Class CouponTemplate
 * @package CouponModule\Model
 */
class CouponTemplate extends DbCouponTemplate
{
    /**
     * CouponTemplate constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return CouponTemplate
     */
    protected function newObject()
    {
        return new CouponTemplate();
    }

    /**
     * @param string|null $id
     * @return CouponTemplate|null
     */
    public static function object(string $id = null)
    {
        $obj = new CouponTemplate();
        if ($id && !$obj->getById($id)) {
            return null;
        }

        return $obj;
    }

    /**
     * @param string $name
     * @param string $desc
     * @param int $min_amount
     * @param int $offer_amount
     * @return CouponTemplate
     * @throws ErrorException
     */
    public static function create(
        string $name,
        string $desc = '',
        $min_amount = 0,
        $offer_amount = 0
    ) {
        if (empty($name)) {
            throw new ErrorException('"name" should not be empty: '.$name);
        }
        if ($min_amount < 0) {
            $min_amount = 0;
        }
        if ($offer_amount < 0) {
            throw new ErrorException('"offer_amount" should be positive integer: '.$offer_amount);
        }

        $obj = new CouponTemplate();
        $obj->name = $name;
        $obj->desc = $desc;
        $obj->min_amount = $min_amount;
        $obj->offer_amount = $offer_amount;

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
        return (new CouponTemplate())->select($where, $limit, $page, $order);
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
