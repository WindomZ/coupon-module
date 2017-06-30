<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Exception\ErrorException;

/**
 * Class BaseTemplate2
 * @package CouponModule\Database
 */
abstract class BaseTemplate2 extends BaseTemplate1
{
    const COL_DESC = 'desc';
    const COL_LEVEL = 'level';

    /**
     * @var string
     */
    public $desc = '';

    /**
     * @var int
     */
    public $level = 0;

    /**
     * @return array
     */
    protected function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                self::COL_DESC => $this->desc,
                self::COL_LEVEL => $this->level,
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

        $this->desc = $data[self::COL_DESC];
        $this->level = intval($data[self::COL_LEVEL]);

        return $this;
    }

    /**
     * @throws ErrorException
     */
    protected function beforePost()
    {
        parent::beforePost();
    }

    /**
     * @throws ErrorException
     */
    protected function beforePut()
    {
        parent::beforePut();
    }
}
