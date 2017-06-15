<?php declare(strict_types=1);

namespace CouponModule\Config;

use PDO;

/**
 * Class Config
 * @package CouponModule\Config
 */
class Config extends \Noodlehaus\Config
{
    /**
     * @return array
     */
    protected function getDefaults()
    {
        return [
            'database_host' => '127.0.0.1',
            'database_port' => 3306,
            'database_type' => 'mysql',
            'database_name' => 'coupondb',
            'database_username' => 'root',
            'database_password' => 'root',
            'database_charset' => 'utf8',
            'database_logging' => false,
            'database_prefix' => 'cp_',
            'database_option' => [
                PDO::ATTR_CASE => PDO::CASE_NATURAL,
            ],
            'database_command' => [
                'SET SQL_MODE=ANSI_QUOTES',
            ],
        ];
    }
}
