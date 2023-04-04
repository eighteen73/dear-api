<?php

/**
 * Part of Dear package.
 *
 * @package Dear
 * @version 1.0
 * @author Matt Jones
 * @license MIT
 * @copyright Copyright (c) 2022 Eighteen73
 *
 */

namespace Eighteen73\Dear\Api;
class PriceTiers extends BaseApi
{
    protected function getAction(): string
    {
        return 'ref/priceTier';
    }

    protected function getGUID(): string
    {
        // This endpoint does not have GUIDs
        return '';
    }
}