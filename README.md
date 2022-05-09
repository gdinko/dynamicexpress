# Laravel DynamicExpress API Wrapper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gdinko/dynamicexpress.svg?style=flat-square)](https://packagist.org/packages/gdinko/dynamicexpress)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/gdinko/dynamicexpress/run-tests?label=tests)](https://github.com/gdinko/dynamicexpress/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/gdinko/dynamicexpress/Check%20&%20fix%20styling?label=code%20style)](https://github.com/gdinko/dynamicexpress/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/gdinko/dynamicexpress.svg?style=flat-square)](https://packagist.org/packages/gdinko/dynamicexpress)


Laravel DynamicExpress API Wrapper

[DynamicExpress API Documentation](https://www.dynamicexpress.eu/soap_info/classes/DSoapServerClass.html)

## Installation

You can install the package via composer:

```bash
composer require gdinko/dynamicexpress
```

If you plan to use database for storing nomenclatures:

```bash
php artisan migrate
```

If you need to export configuration file:

```bash
php artisan vendor:publish --provider="gdinko\dynamicexpress\DynamicExpressServiceProvider" --tag=config
```

## Configuration

```bash
DYNAMICEXPRESS_API_USER=
DYNAMICEXPRESS_API_PASS=
DYNAMICEXPRESS_API_WSDL= #default = https://system.dynamicexpress.eu/schema.wsdl
```

## Usage

```php
//
```

## Examples


### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email dinko359@gmail.com instead of using the issue tracker.

## Credits

-   [Dinko Georgiev](https://github.com/gdinko)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.