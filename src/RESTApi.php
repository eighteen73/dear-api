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

interface RESTApi
{
    public function get(array $parameters = []): mixed;

    public function find(string $guid, array $parameters = []): mixed;

    public function create(array $parameters = []): mixed;

    public function update(string $guid, array $parameters = []): mixed;

    public function delete(string $guid, array $parameters = []): mixed;
}