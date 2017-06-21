<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Exception\ErrorException;
use CouponModule\Util\Uuid;

/**
 * Class CouponPack
 * @package CouponModule\Database
 */
class CouponPack extends BaseTemplate2
{
    const COL_ACTIVITY_ID = 'activity_id';
    const COL_TEMPLATE_ID = 'template_id';
    const COL_COUPON_SIZE = 'coupon_size';
    const COL_COUPON_COUNT = 'coupon_count';
    const COL_DEAD_TIME = 'dead_time';
    const COL_DEAD_DAY = 'dead_day';

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
    public $coupon_size = 0;

    /**
     * @var int
     */
    public $coupon_count = 0;

    /**
     * @var string
     */
    public $dead_time;

    /**
     * @var int
     */
    public $dead_day = 0;

    /**
     * @return CouponPack
     */
    protected function newObject()
    {
        return new CouponPack();
    }

    const TABLE_NAME = 'coupon_pack';

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return self::TABLE_NAME;
    }

    /**
     * @return array
     */
    protected function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                self::COL_ACTIVITY_ID => $this->activity_id,
                self::COL_TEMPLATE_ID => $this->template_id,
                self::COL_COUPON_SIZE => $this->coupon_size,
                self::COL_COUPON_COUNT => $this->coupon_count,
                self::COL_DEAD_TIME => $this->dead_time,
                self::COL_DEAD_DAY => $this->dead_day,
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

        $this->activity_id = $data[self::COL_ACTIVITY_ID];
        $this->template_id = $data[self::COL_TEMPLATE_ID];
        $this->coupon_size = intval($data[self::COL_COUPON_SIZE]);
        $this->coupon_count = intval($data[self::COL_COUPON_COUNT]);
        $this->dead_time = $data[self::COL_DEAD_TIME];
        $this->dead_day = intval($data[self::COL_DEAD_DAY]);

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
        if (!Uuid::isValid($this->activity_id)) {
            throw new ErrorException('"activity_id" should be UUID!');
        }
        if (!Uuid::isValid($this->template_id)) {
            throw new ErrorException('"template_id" should be UUID!');
        }
        if ($this->coupon_size <= 0) {
            throw new ErrorException('"coupon_size" should be positive!');
        }
        if ($this->coupon_count < 0) {
            throw new ErrorException('"coupon_count" should be positive or zero!');
        }
        if (empty($this->dead_time)) {
            throw new ErrorException('"dead_time" should be a date!');
        }
        if ($this->dead_day < 0) {
            $this->dead_day = 0;
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
