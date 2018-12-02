[![Travis](https://img.shields.io/travis/mintware-de/dmm-json.svg)](https://travis-ci.org/mintware-de/data-model-mapper)
[![Packagist](https://img.shields.io/packagist/v/mintware-de/dmm-json.svg)](https://packagist.org/packages/mintware-de/data-model-mapper)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/mintware-de/data-model-mapper/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/dt/mintware-de/dmm-json.svg)](https://packagist.org/packages/mintware-de/data-model-mapper)

# JSON for DMM

This package provides JSON handling for [mintware-de/data-model-mapper](https://github.com/mintware-de/data-model-mapper)

## Installation

```bash
$ composer require mintware-de/dmm-json
```

## Usage

```php
<?php

use Mintware\DMM\ObjectMapper;
use MintWare\DMM\Serializer\JsonSerializer;

$mapper = new ObjectMapper(new JsonSerializer());
```

For more usage tips check [the documentation](https://github.com/mintware-de/data-model-mapper/doc/index.md)

## Testing
```bash
$ phpunit
```

## Contribute
Feel free to fork, contribute and create pull requests
