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
    public function test_get_time_stamp()
    {
        $this->assertNotEmpty(Date::get_now_time_stamp());
        $this->assertEquals(Date::get_now_time_stamp(), time());
    }

    /**
     *
     */
    public function test_get_time()
    {
        $this->assertEquals(gettype(Date::get_now_time()), 'string');

        $this->assertEquals(
            substr(Date::get_next_time(), 0, 10),
            substr(Date::get_next_zero_time(), 0, 10)
        );
        $this->assertEquals(
            substr(Date::get_next_time(86400), 0, 10),
            substr(Date::get_next_zero_time(86400), 0, 10)
        );

        $this->assertEquals(substr(Date::get_next_zero_time(), 11, 8), '00:00:00');
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
