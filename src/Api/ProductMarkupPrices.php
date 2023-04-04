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

use Eighteen73\Dear\Api\Contracts\PutMethodAllowed;

class ProductMarkupPrices extends BaseApi implements PutMethodAllowed
{
    protected function getGUID(): string
    {
        return "ProductID";
    }

    protected function getAction(): string
    {
        return 'product/markupprices';
    }

    public function update(string $guid, array $parameters = []): array
    {
        $parameters['ProductID'] = $guid;
        return $this->execute('PUT', $parameters);
    }
}