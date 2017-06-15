<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Exception\ErrorException;
use CouponModule\Coupon;

/**
 * Class base
 * @package CouponModule\Database
 */
abstract class Base
{
    /**
     * Base constructor.
     */
    protected function __construct()
    {
    }

    /**
     * @return mixed
     */
    abstract protected function newObject();

    /**
     * @return Database
     */
    protected function DB()
    {
        return Coupon::getInstance()->getDatabase();
    }

    /**
     * @return string
     */
    abstract protected function getTableName(): string;

    /**
     * @return array
     */
    abstract protected function toArray(): array;

    /**
     * @param array $data
     * @return object
     */
    abstract protected function toInstance(array $data);

    /**
     * @throws ErrorException
     */
    abstract protected function beforePost();

    /**
     * @throws ErrorException
     */
    abstract protected function beforePut();

    /**
     * @return bool
     * @throws ErrorException
     */
    public function post(): bool
    {
        $this->beforePost();

        $query = $this->DB()->insert($this->getTableName(), $this->toArray());
        if ($query->errorCode() !== '00000') {
            throw new ErrorException($query->errorInfo()[2]);
        }

        return true;
    }

    /**
     * @param array|string $columns
     * @return array
     */
    abstract protected function columns2data($columns): array;

    /**
     * @param array|string $columns
     * @param array $where
     * @return bool
     * @throws ErrorException
     */
    public function put($columns, array $where = []): bool
    {
        $this->beforePut();

        $data = $this->columns2data($columns);
        if (empty($data)) {
            return false;
        }

        $query = $this->DB()->update($this->getTableName(), $data, $where);
        if ($query->errorCode() !== '00000') {
            throw new ErrorException($query->errorInfo()[2]);
        }

        return true;
    }

    /**
     * @param array|null $where
     * @return bool
     */
    protected function get(array $where = null): bool
    {
        $data = $this->DB()->get($this->getTableName(), '*', $where);
        if (!$data) {
            return false;
        }

        return !empty($this->toInstance($data));
    }

    /**
     * @param array|null $where
     * @return int
     */
    protected function count(array $where = null): int
    {
        $count = $this->DB()->count($this->getTableName(), $where);
        if (!$count) {
            return -1;
        }

        return $count;
    }

    /**
     * @param string $where
     * @param array $map
     * @return int
     */
    protected function countQuery(string $where, array $map = []): int
    {
        if (empty($where)) {
            return -1;
        }

        $query = 'SELECT COUNT(*) FROM '
            .$this->DB()->tableQuote($this->getTableName())
            .' WHERE '
            .$where;
        $date = $this->DB()->query($query, $map)->fetchAll();
        if (empty($date) || empty($date[0])) {
            return -1;
        }

        $count = intval($date[0]['COUNT(*)']);
        if (!$count) {
            return -1;
        }

        return $count;
    }

    /**
     * @param string $column
     * @param int $count
     * @param array $where
     * @param array $data
     * @return bool
     * @throws ErrorException
     */
    protected function increase(string $column, int $count = 1, array $where, array $data = []): bool
    {
        if (empty($column) || empty($count)) {
            return false;
        }

        $this->beforePut();

        $data = array_merge($data, [$column.'[+]' => $count]);
        if (empty($data)) {
            return false;
        }

        $query = $this->DB()->update($this->getTableName(), $data, $where);
        if ($query->errorCode() !== '00000') {
            throw new ErrorException($query->errorInfo()[2]);
        }

        return true;
    }
}
