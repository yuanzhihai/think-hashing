<?php

namespace yzh52521\Hashing;

use think\Facade;

/**
 * Class Filesystem
 * @package think\facade
 * @mixin \yzh52521\Hashing\HashManager
 * @method static driver( string $driver = null ) ,null|string
 * @method static array info(string $hashedValue)
 * @method static bool check(string $value, string $hashedValue, array $options = [])
 * @method static bool needsRehash(string $hashedValue, array $options = [])
 * @method static string make(string $value, array $options = [])
 * @method static extend($driver, \Closure $callback)
 */
class Hash extends Facade
{
    protected static function getFacadeClass()
    {
        return HashManager::class;
    }
}