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

namespace Eighteen73\Dear\Api;

class ProductAvailability extends BaseApi
{
    protected function getGUID(): string
    {
        return "ID";
    }

    protected function getAction(): string
    {
        return 'ref/productavailability';
    }
}