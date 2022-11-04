<?php
declare( strict_types = 1 );
/**
 * This file is part of hyperf-ext/hashing.
 *
 * @link     https://github.com/hyperf-ext/hashing
 * @contact  eric@zhu.email
 * @license  https://github.com/hyperf-ext/hashing/blob/master/LICENSE
 */

namespace yzh52521\Hashing\Contract;

interface HashInterface
{
    /**
     * Get a driver instance.
     *
     * @return \yzh52521\Hashing\Contract\DriverInterface
     */
    public function driver(?string $name = null): DriverInterface;
}