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

use Eighteen73\Dear\Api\BaseApi;

class Helper
{
    public static function prepareParameters(array $parameters): array
    {
        // set limit & page
        if (!isset($parameters['page'])) {
            $parameters['page'] = BaseApi::PAGE;
        }

        if (!isset($parameters['limit'])) {
            $parameters['limit'] = BaseApi::LIMIT;
        }

        return $parameters;
    }
}