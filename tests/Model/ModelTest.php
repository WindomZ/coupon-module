<?php declare(strict_types=1);

namespace CouponModule\Test\Model;

use CouponModule\Coupon as _Coupon;
use CouponModule\Exception\ErrorException;
use CouponModule\Model\CouponActivity;
use CouponModule\Model\Coupon;
use CouponModule\Model\CouponManager;
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

        $list = CouponActivity::list([CouponActivity::COL_NAME => '这是名称name'], 10, 0);
        if (!$list || !$list['size']) {
            $obj = CouponActivity::create(
                '这是名称name',
                '这是描述desc',
                1
            );
            $obj->level = 1;
            $obj->class = 1;
            $obj->kind = 2;
            try {
                self::assertFalse($obj->post());
            } catch (ErrorException $e) {
                self::assertNotEmpty($e);
            }

            $obj->dead_time = Date::get_next_time(2);
            self::assertTrue($obj->post());

            $list = CouponActivity::list([CouponActivity::COL_NAME => '这是名称name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        self::assertEquals($ins->name, '这是名称name');
        self::assertEquals($ins->desc, '这是描述desc');
        self::assertEquals($ins->coupon_limit, 1);
        self::assertEquals($ins->level, 1);
        self::assertEquals($ins->class, 1);
        self::assertEquals($ins->kind, 2);

        $ins = CouponActivity::object($ins->id);
        self::assertNotEmpty($ins);

        self::assertEquals($ins->name, '这是名称name');
        self::assertEquals($ins->desc, '这是描述desc');
        self::assertEquals($ins->coupon_limit, 1);
        self::assertEquals($ins->level, 1);
        self::assertEquals($ins->class, 1);
        self::assertEquals($ins->kind, 2);

        self::assertTrue($ins->disable());

        $ins->active = true;
        $ins->dead_time = Date::get_next_time(2);
        self::assertTrue($ins->put([CouponActivity::COL_ACTIVE, CouponActivity::COL_DEAD_TIME]));

        $ins = CouponActivity::object($ins->id);
        self::assertNotEmpty($ins);
        self::assertTrue($ins->active);

        return $ins;
    }

    /**
     * @return CouponTemplate
     */
    public function testCouponTemplate()
    {
        $coupon = _Coupon::getInstance();
        self::assertNotEmpty($coupon);

        $list = CouponTemplate::list([CouponTemplate::COL_NAME => '这是名称name'], 10, 0);
        if (!$list || !$list['size']) {
            $obj = CouponTemplate::create(
                '这是名称name',
                '这是描述desc',
                100,
                200
            );
            $obj->level = 2;
            $obj->class = 2;
            $obj->kind = 4;
            self::assertTrue($obj->post());

            $list = CouponTemplate::list([CouponTemplate::COL_NAME => '这是名称name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        self::assertEquals($ins->name, '这是名称name');
        self::assertEquals($ins->desc, '这是描述desc');
        self::assertEquals($ins->min_amount, 100);
        self::assertEquals($ins->offer_amount, 200);
        self::assertEquals($ins->level, 2);
        self::assertEquals($ins->class, 2);
        self::assertEquals($ins->kind, 4);

        $ins = CouponTemplate::object($ins->id);
        self::assertNotEmpty($ins);

        self::assertEquals($ins->name, '这是名称name');
        self::assertEquals($ins->desc, '这是描述desc');
        self::assertEquals($ins->min_amount, 100);
        self::assertEquals($ins->offer_amount, 200);
        self::assertEquals($ins->level, 2);
        self::assertEquals($ins->class, 2);
        self::assertEquals($ins->kind, 4);

        self::assertTrue($ins->disable());

        $ins->active = true;
        self::assertTrue($ins->put([CouponTemplate::COL_ACTIVE]));

        $ins = CouponTemplate::object($ins->id);
        self::assertNotEmpty($ins);
        self::assertTrue($ins->active);

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

        $list = CouponPack::list([CouponPack::COL_NAME => '这是名称name'], 10, 0);
        if (!$list || !$list['size']) {
            $obj = CouponPack::create(
                '这是名称name',
                '这是描述desc',
                $activity->id,
                $template->id,
                10000
            );
            $obj->dead_day = 7;
            self::assertTrue($obj->post());

            $list = CouponPack::list([CouponPack::COL_NAME => '这是名称name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        self::assertEquals($ins->name, '这是名称name');
        self::assertEquals($ins->desc, '这是描述desc');
        self::assertEquals($ins->activity_id, $activity->id);
        self::assertEquals($ins->template_id, $template->id);
        self::assertEquals($ins->coupon_size, 10000);
        self::assertEquals($ins->level, 1);

        $ins = CouponPack::object($ins->id);
        self::assertNotEmpty($ins);

        self::assertEquals($ins->name, '这是名称name');
        self::assertEquals($ins->desc, '这是描述desc');
        self::assertEquals($ins->activity_id, $activity->id);
        self::assertEquals($ins->template_id, $template->id);
        self::assertEquals($ins->coupon_size, 10000);
        self::assertEquals($ins->level, 1);

        self::assertTrue($ins->disable());

        $ins->active = true;
        self::assertTrue($ins->put([CouponPack::COL_ACTIVE]));

        $ins = CouponPack::object($ins->id);
        self::assertNotEmpty($ins);
        self::assertTrue($ins->active);

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

        $list = Coupon::list([Coupon::COL_NAME => '这是名称name'], 10, 0);
        if (!$list || !$list['size']) {
            $obj = Coupon::create(
                Uuid::uuid(),
                $pack->id
            );
            self::assertTrue($obj->post());

            $list = Coupon::list([Coupon::COL_NAME => '这是名称name'], 10, 0);
        }
        self::assertNotEmpty($list);
        self::assertEquals(sizeof($list), 4);
        self::assertEquals($list['size'], 1);

        $ins = $list['data'][0];
        self::assertNotEmpty($ins);

        self::assertEquals($ins->name, '这是名称name');
        self::assertEquals($ins->desc, '这是描述desc');
        self::assertEquals($ins->activity_id, $pack->activity_id);
        self::assertEquals($ins->template_id, $pack->template_id);
        self::assertEquals($ins->min_amount, 100);
        self::assertEquals($ins->offer_amount, 200);
        self::assertEquals($ins->level, 1);
        self::assertEquals($ins->class, 2);
        self::assertEquals($ins->kind, 4);

        $ins = Coupon::object($ins->id);
        self::assertNotEmpty($ins);

        self::assertEquals($ins->name, '这是名称name');
        self::assertEquals($ins->desc, '这是描述desc');
        self::assertEquals($ins->activity_id, $pack->activity_id);
        self::assertEquals($ins->template_id, $pack->template_id);
        self::assertEquals($ins->min_amount, 100);
        self::assertEquals($ins->offer_amount, 200);
        self::assertEquals($ins->level, 1);
        self::assertEquals($ins->class, 2);
        self::assertEquals($ins->kind, 4);
        self::assertTrue(Date::after($ins->dead_time));

        self::assertTrue($ins->disable());

        self::assertFalse($ins->use());

        $activity = CouponActivity::object($ins->activity_id);
        self::assertNotEmpty($activity);
        $ins->active = true;
        $ins->dead_time = $activity->dead_time;
        self::assertTrue($ins->put([Coupon::COL_ACTIVE, Coupon::COL_DEAD_TIME]));

        self::assertTrue($ins->use());

        $ins = Coupon::object($ins->id);
        self::assertNotEmpty($ins);
        self::assertEquals($ins->used_count, 1);
        self::assertFalse($ins->active);

        $ins->used_count = 0;
        $ins->active = true;
        self::assertTrue($ins->put([Coupon::COL_USED_COUNT, Coupon::COL_ACTIVE]));

        $ins = Coupon::object($ins->id);
        self::assertNotEmpty($ins);
        self::assertEquals($ins->used_count, 0);
        self::assertTrue($ins->active);

        return $ins;
    }

    /**
     * @depends testCouponActivity
     * @depends testCoupon
     * @param CouponActivity $activity
     * @param Coupon $coupon
     */
    public function testManager($activity, $coupon)
    {
        sleep(2);

        self::assertNotEmpty($activity);
        self::assertTrue($activity->active);

        self::assertNotEmpty($coupon);
        self::assertTrue($coupon->active);

        $r = CouponManager::clean();
        self::assertEquals($r['CouponActivity'], 1);
        self::assertEquals($r['Coupon'], 1);

        $activity = CouponActivity::object($activity->id);
        self::assertFalse($activity->active);

        $coupon = Coupon::object($coupon->id);
        self::assertFalse($coupon->active);
    }
}
