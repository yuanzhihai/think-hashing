<?php

declare( strict_types = 1 );
/**
 * This file is part of yzh52521/think-hashing
 *
 * @link     https://github.com/yzh52521/think-hashing
 * @license  https://github.com/yzh52521/think-hashing/blob/master/LICENSE
 */

namespace yzh52521\Hashing\Driver;

abstract class AbstractDriver
{
    /**
     * Get information about the given hashed value.
     */
    public function info(string $hashedValue): array
    {
        return password_get_info( $hashedValue );
    }

    /**
     * Check the given plain value against a hash.
     */
    public function check(string $value,string $hashedValue,array $options = []): bool
    {
        if (strlen( $hashedValue ) === 0) {
            return false;
        }

        return password_verify( $value,$hashedValue );
    }
}