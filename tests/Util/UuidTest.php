<?php declare(strict_types=1);

namespace CouponModule\Test\Util;

use CouponModule\Util\Uuid;
use PHPUnit\Framework\TestCase;

/**
 * Class UuidTest
 * @package CouponModule\Test\Util
 */
class UuidTest extends TestCase
{
    /**
     *
     */
    public function testUuid()
    {
        $this->assertTrue(Uuid::isValid(Uuid::uuid()));
    }
}
