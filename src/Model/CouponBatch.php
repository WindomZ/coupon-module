<?php declare(strict_types=1);

namespace CouponModule\Model;

use CouponModule\Database\CouponBatch as DbCoupon;
use CouponModule\Exception\ErrorException;
use CouponModule\Util\Uuid;

/**
 * Class CouponBatch
 * @package CouponModule\Model
 */
class CouponBatch extends DbCoupon
{
    /**
     * CouponBatch constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return CouponBatch
     */
    protected function newObject()
    {
        return new CouponBatch();
    }

    /**
     * @param string|null $id
     * @return CouponBatch|null
     */
    public static function object(string $id = null)
    {
        $obj = new CouponBatch();
        if ($id && !$obj->getById($id)) {
            return null;
        }

        return $obj;
    }

    /**
     * @param string $owner_id
     * @param string $activity_id
     * @param string $template_id
     * @param string $pack_id
     * @return CouponBatch
     * @throws ErrorException
     */
    public static function create(
        string $owner_id,
        string $activity_id,
        string $template_id,
        string $pack_id
    ) {
        if (!Uuid::isValid($owner_id)) {
            throw new ErrorException('"owner_id" should be UUID: '.$owner_id);
        }
        if (!Uuid::isValid($activity_id)) {
            throw new ErrorException('"activity_id" should be UUID: '.$activity_id);
        }
        if (!Uuid::isValid($template_id)) {
            throw new ErrorException('"template_id" should not be empty: '.$template_id);
        }
        if (!Uuid::isValid($pack_id)) {
            throw new ErrorException('"pack_id" should be UUID: '.$pack_id);
        }

        $obj = new CouponBatch();
        $obj->owner_id = $owner_id;
        $obj->activity_id = $activity_id;
        $obj->template_id = $template_id;
        $obj->pack_id = $pack_id;

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
        return (new CouponBatch())->select($where, $limit, $page, $order);
    }
}
