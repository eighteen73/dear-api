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

use Eighteen73\Dear\Api\Contracts\DeleteMethodAllowed as DeleteContract;
use Eighteen73\Dear\Api\Contracts\PostMethodAllowed as PostContract;

class SaleFulfilment extends BaseApi implements PostContract, DeleteContract
{
    protected function getGUID(): string
    {
        return "SaleID";
    }

    protected function getAction(): string
    {
        return 'sale/fulfilment';
    }
}