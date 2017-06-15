<?php declare(strict_types=1);

namespace CouponModule\Test\Util;

use CouponModule\Util\Date;
use PHPUnit\Framework\TestCase;

/**
 * Class DateTest
 * @package CouponModule\Test\Date
 */
class DateTest extends TestCase
{
    /**
     *
     */
    public function test_get_now_time_stamp()
    {
        $this->assertNotEmpty(Date::get_now_time_stamp());
        $this->assertEquals(Date::get_now_time_stamp(), time());
    }

    /**
     *
     */
    public function test_get_now_time()
    {
        $this->assertEquals(gettype(Date::get_now_time()), 'string');
    }

    /**
     *
     */
    public function test_before()
    {
        $this->assertTrue(Date::before(Date::get_next_time(-1)));
        $this->assertTrue(Date::before(Date::get_next_time(-1), Date::get_next_time()));
    }

    /**
     *
     */
    public function test_after()
    {
        $this->assertTrue(Date::after(Date::get_next_time(1)));
        $this->assertTrue(Date::after(Date::get_next_time(1), Date::get_next_time()));
    }
}
