<?php declare(strict_types=1);

namespace CouponModule\Model;

use CouponModule\Database\Coupon as DbCoupon;
use CouponModule\Exception\ErrorException;
use CouponModule\Util\Uuid;

/**
 * Class Coupon
 * @package CouponModule\Model
 */
class Coupon extends DbCoupon
{
    /**
     * Coupon constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return Coupon
     */
    protected function newObject()
    {
        return new Coupon();
    }

    /**
     * @param string|null $id
     * @return Coupon|null
     */
    public static function object(string $id = null)
    {
        $obj = new Coupon();
        if ($id && !$obj->getById($id)) {
            return null;
        }

        return $obj;
    }

    /**
     * @param string $owner_id
     * @param string $pack_id
     * @return Coupon
     * @throws ErrorException
     */
    public static function create(
        string $owner_id,
        string $pack_id
    ) {
        if (!Uuid::isValid($owner_id)) {
            throw new ErrorException('"owner_id" should be UUID: '.$owner_id);
        }

        if (!Uuid::isValid($pack_id)) {
            throw new ErrorException('"pack_id" should be UUID: '.$pack_id);
        }
        $pack = CouponPack::object($pack_id);
        if (!$pack) {
            throw new ErrorException('"pack_id" should be existed: '.$pack_id);
        }

        if (!Uuid::isValid($pack->activity_id)) {
            throw new ErrorException('"activity_id" should be UUID: '.$pack->activity_id);
        }
        $activity = CouponActivity::object($pack->activity_id);
        if (!$activity) {
            throw new ErrorException('"activity_id" should be existed: '.$pack->activity_id);
        }

        if (!Uuid::isValid($pack->template_id)) {
            throw new ErrorException('"template_id" should be empty: '.$pack->template_id);
        }
        $template = CouponTemplate::object($pack->template_id);
        if (!$template) {
            throw new ErrorException('"template_id" should be existed: '.$pack->template_id);
        }

        $batch = CouponBatch::create($owner_id, $activity->id, $template->id, $pack->id);
        if (!$batch->post()) {
            throw new ErrorException('"batch_id" should be existed: '.$pack->template_id);
        }

        $obj = new Coupon();
        $obj->name = $template->name;
        $obj->desc = $template->desc;
        $obj->activity = $activity;
        $obj->activity_id = $activity->id;
        $obj->template = $template;
        $obj->template_id = $template->id;
        $obj->pack = $pack;
        $obj->pack_id = $pack->id;
        $obj->batch = $batch;
        $obj->batch_id = $batch->id;

        $obj->owner_id = $owner_id;
        $obj->level = $pack->level;
        $obj->active = $pack->active;
        $obj->dead_time = $pack->dead_time;

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
        return (new Coupon())->select($where, $limit, $page, $order);
    }

    /**
     * @return bool
     * @throws ErrorException
     */
    public function post(): bool
    {
        if (!Uuid::isValid($this->owner_id)) {
            throw new ErrorException('"owner_id" should not be empty: '.$this->owner_id);
        }
        if (!Uuid::isValid($this->activity_id)) {
            throw new ErrorException('"activity_id" should not be empty: '.$this->activity_id);
        }
        if (!isset($this->activity)) {
            $this->activity = CouponActivity::object($this->activity_id);
        }
        if (!$this->activity) {
            throw new ErrorException('"activity_id" should be existed: '.$this->activity_id);
        }

        $count = $this->count(
            [
                self::COL_OWNER_ID => $this->owner_id,
                self::COL_ACTIVITY_ID => $this->activity_id,
            ]
        );

        if ($count >= $this->activity->coupon_limit) {
            return false;
        }

        if (!$this->activity->use()) {
            return false;
        }

        return parent::post();
    }

    /**
     * @return bool
     */
    public function pass()
    {
        return $this->active && $this->used_count === 0;
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
        $this->active = false;

        return $this->increase(self::COL_USED_COUNT, 1, [self::COL_ACTIVE]);
    }
}
