<?php

namespace yzh52521\Hashing;

use InvalidArgumentException;
use think\App;
use think\Config;
use think\helper\Str;
use yzh52521\Hashing\Contract\DriverInterface;
use yzh52521\Hashing\Contract\HashInterface;
use yzh52521\Hashing\Driver\Argon2IdDriver;
use yzh52521\Hashing\Driver\Argon2IDriver;
use yzh52521\Hashing\Driver\BcryptDriver;

class HashManager implements HashInterface
{
    /**
     * The config instance.
     *
     * @var \think\Config
     */
    protected $config;

    /**
     * @var App
     */
    protected $app;

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    protected $customCreators = [];

    /**
     * The array of created "drivers".
     *
     * @var \yzh52521\Hashing\Contract\DriverInterface[]
     */
    protected $drivers = [];

    public function __construct(App $app,Config $config)
    {
        $this->app    = $app;
        $this->config = $config;
    }

    /**
     * Get a driver instance.
     *
     * @throws \InvalidArgumentException
     */
    public function driver(?string $driver = null): DriverInterface
    {
        $driver = $driver ?: $this->getDefaultDriver();

        if (is_null( $driver )) {
            throw new InvalidArgumentException( sprintf(
                'Unable to resolve NULL driver for [%s].',static::class
            ) );
        }

        if (!isset( $this->drivers[$driver] )) {
            $this->drivers[$driver] = $this->createDriver( $driver );
        }

        return $this->drivers[$driver];
    }

    protected function createDriver($driver)
    {
        // First, we will determine if a custom driver creator exists for the given driver and
        // if it does not we will check for a creator method for the driver. Custom creator
        // callbacks allow developers to build their own "drivers" easily using Closures.
        if (isset( $this->customCreators[$driver] )) {
            return $this->callCustomCreator( $driver );
        } else {
            $method = 'create'.Str::studly( $driver ).'Driver';

            if (method_exists( $this,$method )) {
                return $this->$method();
            }
        }

        throw new InvalidArgumentException( "Driver [$driver] not supported." );
    }

    /**
     * Create an instance of the Bcrypt hash Driver.
     *
     * @return \yzh52521\Hashing\Driver\BcryptDriver
     */
    public function createBcryptDriver()
    {
        return new BcryptDriver( $this->config->get( 'hashing.bcrypt' ) ?? [] );
    }

    /**
     * Create an instance of the Argon2i hash Driver.
     *
     * @return \yzh52521\Hashing\Driver\Argon2IDriver
     */
    public function createArgonDriver()
    {
        return new Argon2IDriver( $this->config->get( 'hashing.argon' ) ?? [] );
    }

    /**
     * Create an instance of the Argon2id hash Driver.
     *
     * @return \yzh52521\Hashing\Driver\Argon2IdDriver
     */
    public function createArgon2idDriver()
    {
        return new Argon2IdDriver( $this->config->get( 'hashing.argon' ) ?? [] );
    }

    /**
     * Call a custom driver creator.
     *
     * @param string $driver
     * @return mixed
     */
    protected function callCustomCreator($driver)
    {
        return $this->customCreators[$driver]( $this->app );
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get( 'hashing.default','bcrypt' );
    }
}