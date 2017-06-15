<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Exception\ErrorException;

/**
 * Class BaseTemplate1
 * @package CouponModule\Database
 */
abstract class BaseTemplate1 extends BaseId
{
    const COL_NAME = 'name';
    const COL_ACTIVE = 'active';
    const COL_LEVEL = 'level';

    /**
     * @var string
     */
    public $name;

    /**
     * @var bool
     */
    public $active = true;

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
                self::COL_NAME => $this->name,
                self::COL_ACTIVE => $this->active,
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

        $this->name = $data[self::COL_NAME];
        $this->active = boolval($data[self::COL_ACTIVE]);
        $this->level = intval($data[self::COL_LEVEL]);

        return $this;
    }

    /**
     * @throws ErrorException
     */
    protected function beforePost()
    {
        parent::beforePost();

        if (empty($this->name)) {
            throw new ErrorException('"name" should not be empty!"');
        }
    }

    /**
     * @throws ErrorException
     */
    protected function beforePut()
    {
        parent::beforePut();

        if (empty($this->name)) {
            throw new ErrorException('"name" should not be empty!"');
        }
    }
}
