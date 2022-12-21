# dear-api
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/eighteen73/dear-api/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/UmiMood/dear-api/?branch=master)
PHP Library for [DEAR Systems](https://dearinventory.docs.apiary.io) API v2.

Originally forked from [UmiMood/dear-api](https://github.com/UmiMood/dear-api).

## Requirements

* PHP 8.0+
* guzzlehttp/guzzle 7.4+
* ext-json extension

## Installation

```bash
composer require eighteen73/dear-api
```

Otherwise just download the package and add it to the autoloader.

## API Documentation
[DOCS](https://dearinventory.docs.apiary.io)

## Usage


Create a Dear instance.
```php
$dear = Eighteen73\Dear\Dear::create("DEAR-ACCOUNT_ID", "DEAR-APPLICATION-KEY");
```

Get data from API
```php

$products = $dear->product()->get([]);
$accounts = $dear->account()->get([]);
$me = $dear->me()->get([]);

```

Push a new record to the API
```php

$response = $dear->product()->create($params); // see docs for available parameters

```

Update an existing record
```php

$response = $dear->product()->update($guid, $params); // see docs for available parameters

```

Delete a record
```php

$response = $dear->product()->delete($guid, []);

```

## Links ##
* [License](./LICENSE)
