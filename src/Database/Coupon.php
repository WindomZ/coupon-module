<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Exception\ErrorException;
use CouponModule\Util\Date;
use CouponModule\Util\Uuid;

/**
 * Class Coupon
 * @package CouponModule\Database
 */
class Coupon extends CouponTemplate
{
    const COL_OWNER_ID = 'owner_id';
    const COL_ACTIVITY_ID = 'activity_id';
    const COL_TEMPLATE_ID = 'template_id';
    const COL_USED_COUNT = 'used_count';
    const COL_USED_TIME = 'used_time';
    const COL_DEAD_TIME = 'dead_time';

    /**
     * @var string
     */
    public $owner_id;

    /**
     * @var string
     */
    public $activity_id;

    /**
     * @var CouponActivity|null
     */
    public $activity = null;

    /**
     * @var string
     */
    public $template_id;

    /**
     * @var CouponTemplate|null
     */
    public $template = null;

    /**
     * @var int
     */
    public $used_count = 0;

    /**
     * @var string
     */
    public $used_time;

    /**
     * @var string
     */
    public $dead_time;

    /**
     * @return Coupon
     */
    protected function newObject()
    {
        return new Coupon();
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'coupon';
    }

    /**
     * @return array
     */
    protected function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                self::COL_OWNER_ID => $this->owner_id,
                self::COL_ACTIVITY_ID => $this->activity_id,
                self::COL_TEMPLATE_ID => $this->template_id,
                self::COL_USED_COUNT => $this->used_count,
                self::COL_USED_TIME => $this->used_time,
                self::COL_DEAD_TIME => $this->dead_time,
            ]
        );
    }

    /**
     * @param array $data
     * @return $this
     */
    protected function toInstance(array $data)
    {
        parent::toInstance($data);

        $this->owner_id = $data[self::COL_OWNER_ID];
        $this->activity_id = $data[self::COL_ACTIVITY_ID];
        $this->template_id = $data[self::COL_TEMPLATE_ID];
        $this->used_count = intval($data[self::COL_USED_COUNT]);
        $this->used_time = $data[self::COL_USED_TIME];
        $this->dead_time = $data[self::COL_DEAD_TIME];

        return $this;
    }

    /**
     * @param $data
     * @return object
     */
    protected function addInstance($data)
    {
        $obj = $this->newObject()->toInstance($data);
        $this->addList($obj);

        return $obj;
    }

    /**
     * @throws ErrorException
     */
    protected function beforePost()
    {
        if (!Uuid::isValid($this->owner_id)) {
            throw new ErrorException('"owner_id" should be UUID!');
        }
        if (!Uuid::isValid($this->activity_id)) {
            throw new ErrorException('"activity_id" should be UUID!');
        }
        if (!Uuid::isValid($this->template_id)) {
            throw new ErrorException('"template_id" should be UUID!');
        }
        if ($this->used_count < 0) {
            $this->used_count = 0;
        }
        if (empty($this->used_time)) {
            $this->used_time = Date::get_now_time();
        }
        if (empty($this->dead_time)) {
            throw new ErrorException('"dead_time" should be a date!');
        }

        parent::beforePost();
    }

    /**
     * @throws ErrorException
     */
    protected function beforePut()
    {
        $this->beforePost();
        parent::beforePut();
    }
}
