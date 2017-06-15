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

    /**
     * @var string
     */
    public $desc = '';

    /**
     * @return array
     */
    protected function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                self::COL_DESC => $this->desc,
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
