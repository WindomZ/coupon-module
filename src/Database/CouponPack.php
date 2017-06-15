<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Exception\ErrorException;
use CouponModule\Util\Uuid;

class CouponPack extends BaseTemplate2
{
    const COL_ACTIVITY_ID = 'activity_id';
    const COL_TEMPLATE_ID = 'template_id';
    const COL_DEAD_TIME = 'dead_time';

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
     * @var string
     */
    public $dead_time;

    /**
     * @return CouponPack
     */
    protected function newObject()
    {
        return new CouponPack();
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'coupon_pack';
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

        $this->activity_id = $data[self::COL_ACTIVITY_ID];
        $this->template_id = $data[self::COL_TEMPLATE_ID];
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
        if (!Uuid::isValid($this->activity_id)) {
            throw new ErrorException('"activity_id" should be UUID!');
        }
        if (!Uuid::isValid($this->template_id)) {
            throw new ErrorException('"template_id" should be UUID!');
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
