<?php declare(strict_types=1);

namespace CouponModule\Model;

use CouponModule\Database\CouponPack as DbCouponPack;
use CouponModule\Exception\ErrorException;
use CouponModule\Util\Uuid;

/**
 * Class CouponPack
 * @package CouponModule\Model
 */
class CouponPack extends DbCouponPack
{
    /**
     * CouponPack constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return CouponPack
     */
    protected function newObject()
    {
        return new CouponPack();
    }

    /**
     * @param string|null $id
     * @return CouponPack|null
     */
    public static function object(string $id = null)
    {
        $obj = new CouponPack();
        if ($id && !$obj->getById($id)) {
            return null;
        }

        return $obj;
    }

    /**
     * @param string $name
     * @param string $desc
     * @param string $activity_id
     * @param string $template_id
     * @param int $coupon_size
     * @return CouponPack
     * @throws ErrorException
     */
    public static function create(
        string $name,
        string $desc = '',
        string $activity_id,
        string $template_id,
        int $coupon_size = 0
    ) {
        if (empty($name)) {
            throw new ErrorException('"name" should not be empty: '.$name);
        }
        if (!Uuid::isValid($activity_id)) {
            throw new ErrorException('"activity_id" should not be empty: '.$activity_id);
        }
        $activity = CouponActivity::object($activity_id);
        if (!$activity) {
            throw new ErrorException('"activity_id" should be existed: '.$activity_id);
        }

        if (!Uuid::isValid($template_id)) {
            throw new ErrorException('"template_id" should not be empty: '.$template_id);
        }
        $template = CouponTemplate::object($template_id);
        if (!$template) {
            throw new ErrorException('"template_id" should be existed: '.$template_id);
        }

        $obj = new CouponPack();
        $obj->name = $name;
        $obj->desc = $desc;
        $obj->activity = $activity;
        $obj->activity_id = $activity->id;
        $obj->template = $template;
        $obj->template_id = $template->id;
        $obj->coupon_size = $coupon_size;

        $obj->level = $activity->level;
        $obj->active = $activity->active && $template->active;
        $obj->dead_time = $activity->dead_time;

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
        return (new CouponPack())->select($where, $limit, $page, $order);
    }

    /**
     * @return bool
     */
    public function pass()
    {
        return $this->active && $this->coupon_size > $this->coupon_used;
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

    /**
     * @return bool
     * @throws ErrorException
     */
    public function use(): bool
    {
        if (!$this->refresh() || !$this->pass()) {
            return false;
        }

        return $this->increase(self::COL_COUPON_USED, 1);
    }
}
