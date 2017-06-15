<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Exception\ErrorException;
use CouponModule\Util\Date;
use CouponModule\Util\Uuid;

/**
 * Class BaseId
 * @package CouponModule\Database
 */
abstract class BaseId extends BaseList
{
    const COL_ID = 'id';
    const COL_POST_TIME = 'post_time';
    const COL_PUT_TIME = 'put_time';

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $post_time;

    /**
     * @var string
     */
    public $put_time;

    /**
     * @return array
     */
    protected function toArray(): array
    {
        return [
            self::COL_ID => $this->id,
            self::COL_POST_TIME => $this->post_time,
            self::COL_PUT_TIME => $this->put_time,
        ];
    }

    /**
     * @param array $data
     * @return $this
     */
    protected function toInstance(array $data)
    {
        $this->id = $data[self::COL_ID];
        $this->post_time = $data[self::COL_POST_TIME];
        $this->put_time = $data[self::COL_PUT_TIME];

        return $this;
    }

    /**
     * @throws ErrorException
     */
    protected function beforePost()
    {
    }

    /**
     * @return bool
     */
    public function post(): bool
    {
        if (!Uuid::isValid($this->id)) {
            $this->id = Uuid::uuid();
        }
        $this->post_time = Date::get_now_time();
        $this->put_time = Date::get_now_time();

        return parent::post();
    }

    /**
     * @throws ErrorException
     */
    protected function beforePut()
    {
        Uuid::isValid($this->id);
    }

    /**
     * @param array|string $columns
     * @return array
     */
    protected function columns2data($columns): array
    {
        if (empty($columns)) {
            return [];
        }

        $data = $this->toArray();

        if ($columns !== '*') {
            $columns = array_diff($columns, [self::COL_ID]);
            $data = array_intersect_key($data, array_flip($columns));
        }

        return $data;
    }

    /**
     * @param array|string $columns
     * @param array $where
     * @return bool
     * @throws ErrorException
     */
    public function put($columns, array $where = []): bool
    {
        if ($columns !== '*') {
            $columns = array_diff($columns, [self::COL_ID]);
            $columns = array_diff($columns, [self::COL_POST_TIME]);
            array_push($columns, self::COL_PUT_TIME);
        }

        if (!array_key_exists(self::COL_ID, $where)) {
            $where[self::COL_ID] = $this->id;
        }

        $this->put_time = Date::get_now_time();

        return parent::put($columns, $where);
    }

    /**
     * @param string $column
     * @param int $count
     * @param array $where
     * @param array $data
     * @return bool
     * @throws ErrorException
     */
    protected function increase(string $column, int $count = 1, array $where = [], array $data = []): bool
    {
        if (!array_key_exists(self::COL_ID, $where)) {
            $where[self::COL_ID] = $this->id;
        }

        return parent::increase($column, $count, $where, $data);
    }

    /**
     * @param string $id
     * @return bool
     */
    protected function getById(string $id): bool
    {
        if (Uuid::isValid($id)) {
            return parent::get([self::COL_ID => $id]);
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function refresh(): bool
    {
        return $this->getById($this->id);
    }
}
