<?php

/**
 * Part of Dear package.
 *
 * @package Dear
 * @version 1.0
 * @author Umair Mahmood
 * @license MIT
 * @copyright Copyright (c) 2019 Umair Mahmood
 *
 */

namespace Eighteen73\Dear;

class Dear
{
    protected static self|null $instance = null;

    protected Config $config;

    protected function __construct(string $accountId = null, string $applicationKey = null)
    {
        $this->config = new Config($accountId, $applicationKey);
    }

    public static function create(string $accountId = null, string $applicationKey = null): self
    {
        return (static::$instance) ?: new static($accountId, $applicationKey);
    }

    public function __call(string $name, mixed $arguments): mixed
    {
        $class = "\\Eighteen73\\Dear\\Api\\" . ucwords($name);
        if (class_exists($class)) {
            return new $class($this->config);
        }

        throw new \BadMethodCallException("undefined method $name called.");
    }
}
