<?php declare(strict_types=1);

namespace CouponModule;

use CouponModule\Config\Config;
use CouponModule\Database\Database;

/**
 * Class Coupon
 * @package CouponModule
 */
class Coupon
{
    /**
     * @var Coupon
     */
    private static $_instance;

    private function __clone()
    {
    }

    /**
     * @return Coupon
     */
    public static function getInstance(): Coupon
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new Coupon();
        }

        return self::$_instance;
    }

    /**
     * @var Config
     */
    protected $config;

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @var Database
     */
    protected $database;

    /**
     * @return Database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @var string
     */
    private static $configPath = __DIR__.'config.yml';

    /**
     * @param string $configPath
     */
    public static function setConfigPath(string $configPath)
    {
        self::$configPath = $configPath;
    }

    /**
     *
     * Coupon constructor.
     */
    private function __construct()
    {
        $this->config = new Config(self::$configPath);
        $this->database = new Database($this->config);
        self::$_instance = $this;
    }
}
