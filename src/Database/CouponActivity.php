<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Exception\ErrorException;

/**
 * Class CouponActivity
 * @package CouponModule\Database
 */
class CouponActivity extends BaseTemplate3
{
    const COL_URL = 'url';
    const COL_CLASS = 'class';
    const COL_KIND = 'kind';
    const COL_COUPON_LIMIT = 'coupon_limit';
    const COL_DEAD_TIME = 'dead_time';

    /**
     * @var string
     */
    public $url = '';

    /**
     * @var int
     */
    public $class = 0;

    /**
     * @var int
     */
    public $kind = 0;

    /**
     * @var int
     */
    public $coupon_limit = 0;

    /**
     * @var string
     */
    public $dead_time;

    /**
     * @return CouponActivity
     */
    protected function newObject()
    {
        return new CouponActivity();
    }

    const TABLE_NAME = 'coupon_activity';

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
                self::COL_URL => $this->url,
                self::COL_CLASS => $this->class,
                self::COL_KIND => $this->kind,
                self::COL_COUPON_LIMIT => $this->coupon_limit,
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

        $this->url = $data[self::COL_URL];
        $this->class = intval($data[self::COL_CLASS]);
        $this->kind = intval($data[self::COL_KIND]);
        $this->coupon_limit = intval($data[self::COL_COUPON_LIMIT]);
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
        if ($this->class < 0) {
            $this->class = 0;
        }
        if ($this->kind < 0) {
            $this->kind = 0;
        }
        if ($this->coupon_limit < 0) {
            $this->coupon_limit = 0;
        }
        if (empty($this->dead_time)) {
            throw new ErrorException('"dead_time" should be a date: '.$this->dead_time);
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
