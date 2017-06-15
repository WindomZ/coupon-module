<?php declare(strict_types=1);

namespace CouponModule\Util;

use Ramsey\Uuid\Uuid as _Uuid;

/**
 * Class Uuid
 * @package CouponModule\Util
 */
class Uuid
{
    /**
     * @return string
     */
    public static function uuid(): string
    {
        return _Uuid::uuid4()->toString();
    }

    /**
     * @param string|null $uuid
     * @return bool
     */
    public static function isValid($uuid = ''): bool
    {
        if (empty($uuid)) {
            return false;
        }

        return _Uuid::isValid($uuid);
    }
}
