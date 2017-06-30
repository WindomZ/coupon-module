<?php declare(strict_types=1);

namespace CouponModule\Database;

/**
 * Class BaseList
 * @package CouponModule\Database
 */
abstract class BaseList extends BaseCommon
{
    /**
     * @var array
     */
    protected $select_list = array();

    /**
     * @return array
     */
    protected function getList(): array
    {
        return $this->select_list;
    }

    /**
     * @param $obj
     */
    protected function addList($obj)
    {
        if (!empty($obj)) {
            $this->select_list[] = $obj;
        }
    }

    /**
     * @var int
     */
    protected $select_size = 0;

    /**
     * @return int
     */
    protected function getSize(): int
    {
        return $this->select_size;
    }

    /**
     * @param $data
     * @return object
     */
    abstract protected function addInstance($data);

    /**
     * @param array|null $where
     * @param int $limit
     * @param int $page
     * @param array|null $order
     * @return bool
     */
    private function _select(array $where = null, int $limit = 0, int $page = 0, array $order = null)
    {
        $this->select_size = self::DB()->count($this->getTableName(), $where);
        if (!$this->select_size) {
            return true;
        }

        if ($limit > 0) {
            if (!$where) {
                $where = array();
            }
            if ($page > 0) {
                $where['LIMIT'] = [$limit * $page, $limit];
            } else {
                $where['LIMIT'] = $limit;
            }
        }

        if (!empty($order)) {
            if (!$where) {
                $where = array();
            }
            $where['ORDER'] = $order;
        }

        $data = self::DB()->select($this->getTableName(), '*', $where);

        if (!$data || !is_array($data)) {
            return false;
        }

        foreach ($data as $item) {
            if (empty($this->addInstance($item))) {
                return false;
            }
        }

        return true;
    }

    const ARG_DATA = 'data';
    const ARG_SIZE = 'size';
    const ARG_LIMIT = 'limit';
    const ARG_PAGE = 'page';

    /**
     * @param array|null $where
     * @param int $limit
     * @param int $page
     * @param array|null $order
     * @return array|null
     */
    public function select(array $where = null, int $limit = 0, int $page = 0, array $order = null)
    {
        if ($this->_select($where, $limit, $page, $order)) {
            return [
                self::ARG_DATA => $this->getList(),
                self::ARG_SIZE => $this->getSize(),
                self::ARG_LIMIT => $limit,
                self::ARG_PAGE => $page,
            ];
        }

        return null;
    }
}
