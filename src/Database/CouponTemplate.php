<?php declare(strict_types=1);

namespace CouponModule\Database;

use CouponModule\Exception\ErrorException;

class CouponTemplate extends BaseTemplate2
{
    const COL_CLASS = 'class';
    const COL_KIND = 'kind';
    const COL_PRODUCT_ID = 'product_id';
    const COL_MIN_AMOUNT = 'min_amount';
    const COL_OFFER_AMOUNT = 'offer_amount';

    /**
     * @var int
     */
    public $class = 0;

    /**
     * @var int
     */
    public $kind = 0;

    /**
     * @var string
     */
    public $product_id = '';

    /**
     * @var float
     */
    public $min_amount = 0;

    /**
     * @var float
     */
    public $offer_amount = 0;

    /**
     * @return CouponTemplate
     */
    protected function newObject()
    {
        return new CouponTemplate();
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return 'coupon_template';
    }

    /**
     * @return array
     */
    protected function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                self::COL_CLASS => $this->class,
                self::COL_KIND => $this->kind,
                self::COL_PRODUCT_ID => $this->product_id,
                self::COL_MIN_AMOUNT => $this->min_amount,
                self::COL_OFFER_AMOUNT => $this->offer_amount,
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

        $this->class = intval($data[self::COL_CLASS]);
        $this->kind = intval($data[self::COL_KIND]);
        $this->product_id = $data[self::COL_PRODUCT_ID];
        $this->min_amount = intval($data[self::COL_MIN_AMOUNT]);
        $this->offer_amount = intval($data[self::COL_OFFER_AMOUNT]);

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
        if ($this->min_amount < 0) {
            throw new ErrorException('"min_amount" should be positive!');
        }
        if ($this->offer_amount < 0) {
            throw new ErrorException('"offer_amount" should be positive!');
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
