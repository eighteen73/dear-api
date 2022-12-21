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

class Config
{
    /**
     * @var string
     */
    protected string $accountId;

    /**
     * @var string
     */
    protected string $applicationKey;

    public function __construct(string $accountId = null, string $applicationKey = null)
    {
        $this->setAccountId($accountId ?: getenv('DEAR_ACCOUNT_ID'));
        $this->setApplicationKey($applicationKey ?: getenv('DEAR_APPLICATION_KEY'));
    }

    public function getAccountId(): string
    {
        return $this->accountId;
    }

    public function setAccountId(string $accountId): void
    {
        $this->accountId = $accountId;
    }

    public function getApplicationKey(): string
    {
        return $this->applicationKey;
    }

    public function setApplicationKey($applicationKey): string
    {
        $this->applicationKey = $applicationKey;
    }
}