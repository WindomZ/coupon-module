<?php declare(strict_types=1);

namespace CouponModule\Test\Model;

use CouponModule\Coupon as _Coupon;
use CouponModule\Exception\ErrorException;
use CouponModule\Model\CouponActivity;
use CouponModule\Model\Coupon;
use CouponModule\Model\CouponTemplate;
use CouponModule\Model\CouponPack;
use CouponModule\Util\Date;
use CouponModule\Util\Uuid;
use PHPUnit\Framework\TestCase;

/**
 * Class ModelTest
 * @package CouponModule\Test\Model
 */
class ModelTest extends TestCase
{
    /**
     * @return CouponActivity
     */
    public function testCouponActivity()
    {
        $coupon = _Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = CouponActivity::list([CouponActivity::COL_NAME => 'name'], 10, 0);
        if (!$list || !$list['size']) {
            $obj = CouponActivity::create(
                'name',
                '这是描述',
                10000,
                1
            );
            try {
                $this->assertFalse($obj->post());
            } catch (ErrorException $e) {
                $this->assertNotEmpty($e);
            }

            $obj->dead_time = Date::get_now_time();
            $this->assertTrue($obj->post());

            $list = CouponActivity::list([CouponActivity::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->coupon_size, 10000);
        $this->assertEquals($ins->coupon_limit, 1);

        $ins = CouponActivity::object($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->coupon_size, 10000);
        $this->assertEquals($ins->coupon_limit, 1);

        $this->assertTrue($ins->disable());

        $ins->active = true;
        $this->assertTrue($ins->put([CouponActivity::COL_ACTIVE]));

        $ins = CouponActivity::object($ins->id);
        self::assertNotEmpty($ins);
        $this->assertTrue($ins->active);

        return $ins;
    }

    /**
     * @return CouponTemplate
     */
    public function testCouponTemplate()
    {
        $coupon = _Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = CouponTemplate::list([CouponTemplate::COL_NAME => 'name'], 10, 0);
        if (!$list || !$list['size']) {
            $obj = CouponTemplate::create(
                'name',
                '这是描述',
                100,
                200
            );
            $this->assertTrue($obj->post());

            $list = CouponTemplate::list([CouponTemplate::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        $ins = CouponTemplate::object($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->min_amount, 100);
        $this->assertEquals($ins->offer_amount, 200);

        $this->assertTrue($ins->disable());

        $ins->active = true;
        $this->assertTrue($ins->put([CouponTemplate::COL_ACTIVE]));

        $ins = CouponTemplate::object($ins->id);
        self::assertNotEmpty($ins);
        $this->assertTrue($ins->active);

        return $ins;
    }

    /**
     * @depends testCouponActivity
     * @depends testCouponTemplate
     * @param CouponActivity $activity
     * @param CouponTemplate $template
     * @return CouponPack|null
     */
    public function testCouponPack($activity, $template)
    {
        self::assertNotEmpty($activity);
        self::assertNotEmpty($template);

        $coupon = _Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = CouponPack::list([CouponPack::COL_NAME => 'name'], 10, 0);
        if (!$list || !$list['size']) {
            $obj = CouponPack::create(
                'name',
                '这是描述',
                $activity->id,
                $template->id
            );
            $this->assertTrue($obj->post());

            $list = CouponPack::list([CouponPack::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->activity_id, $activity->id);
        $this->assertEquals($ins->template_id, $template->id);

        $ins = CouponPack::object($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->activity_id, $activity->id);
        $this->assertEquals($ins->template_id, $template->id);

        $this->assertTrue($ins->disable());

        $ins->active = true;
        $this->assertTrue($ins->put([CouponPack::COL_ACTIVE]));

        $ins = CouponPack::object($ins->id);
        self::assertNotEmpty($ins);
        $this->assertTrue($ins->active);

        return $ins;
    }

    /**
     * @depends testCouponPack
     * @param CouponPack $pack
     * @return Coupon|null
     */
    public function testCoupon($pack)
    {
        self::assertNotEmpty($pack);

        $coupon = _Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = Coupon::list([Coupon::COL_NAME => 'name'], 10, 0);
        if (!$list || !$list['size']) {
            $obj = Coupon::create(
                Uuid::uuid(),
                $pack->id
            );
            $this->assertTrue($obj->post());

            $list = Coupon::list([Coupon::COL_NAME => 'name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->activity_id, $pack->activity_id);
        $this->assertEquals($ins->template_id, $pack->template_id);

        $ins = Coupon::object($ins->id);
        self::assertNotEmpty($ins);

        $this->assertEquals($ins->name, 'name');
        $this->assertEquals($ins->desc, '这是描述');
        $this->assertEquals($ins->activity_id, $pack->activity_id);
        $this->assertEquals($ins->template_id, $pack->template_id);

        $this->assertTrue($ins->disable());

        $ins->active = true;
        $this->assertTrue($ins->put([Coupon::COL_ACTIVE]));

        $ins = Coupon::object($ins->id);
        self::assertNotEmpty($ins);
        $this->assertTrue($ins->active);

        return $ins;
    }
}
