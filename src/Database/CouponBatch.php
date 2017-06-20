<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Exception\ErrorException;
use CouponModule\Util\Uuid;

/**
 * Class CouponBatch
 * @package CouponModule\Database
 */
class CouponBatch extends BaseId
{
    const COL_OWNER_ID = 'owner_id';
    const COL_ACTIVITY_ID = 'activity_id';

    /**
     * @var string
     */
    public $owner_id;

    /**
     * @var string
     */
    public $activity_id;

    /**
     * @return CouponBatch
     */
    protected function newObject()
    {
        return new CouponBatch();
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'coupon_batch';
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
