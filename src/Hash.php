<?php

namespace yzh52521\Hashing;

use think\facade\App;
use yzh52521\Hashing\Contract\DriverInterface;
use yzh52521\Hashing\Contract\HashInterface;

abstract class Hash
{
    public static function getDriver(?string $driver = null): DriverInterface
    {
        return App::getInstance()->get( HashInterface::class )->driver( $driver );
    }

    public static function info(string $hashedValue,?string $driverName = null): array
    {
        return static::getDriver( $driverName )->info( $hashedValue );
    }

    public static function make(string $value,array $options = [],?string $driverName = null): string
    {
        return static::getDriver( $driverName )->make( $value,$options );
    }

    public static function check(string $value,string $hashedValue,array $options = [],?string $driverName = null): bool
    {
        return static::getDriver( $driverName )->check( $value,$hashedValue,$options );
    }

    public static function needsRehash(string $hashedValue,array $options = [],?string $driverName = null): bool
    {
        return static::getDriver( $driverName )->needsRehash( $hashedValue,$options );
    }
}