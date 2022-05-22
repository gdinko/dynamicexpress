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
php artisan vendor:publish --tag=dynamicexpress-config
```

If you need to export migrations:

```bash
php artisan vendor:publish --tag=dynamicexpress-migrations
```

If you need to export models:

```bash
php artisan vendor:publish --tag=dynamicexpress-models
```

If you need to export commands:

```bash
php artisan vendor:publish --tag=dynamicexpress-commands
```

## Configuration

```bash
DYNAMICEXPRESS_API_USER=
DYNAMICEXPRESS_API_PASS=
DYNAMICEXPRESS_API_WSDL= #default = https://system.dynamicexpress.eu/schema.wsdl
```

## Usage

Runtime Setup
```php
DynamicExpress::setAccount('user', 'pass');

DynamicExpress::addAccountToStore('AccountUser', 'AccountPass');
DynamicExpress::getAccountFromStore('AccountUser');
DynamicExpress::setAccountFromStore('AccountUser');
```

Multiple Account Support In AppServiceProvider add accounts in boot method
```php
public function boot()
{
    DynamicExpress::addAccountToStore(
        'AccountUser',
        'AccountPass'
    );

    DynamicExpress::addAccountToStore(
        'AccountUser_XXX',
        'AccountPass_XXX'
    );
}
```

Commands

```bash
#sync countries with database (use -h to view options)
php artisan dynamic-express:sync-countries  

#sync cities with database (use -h to view options)
php artisan dynamic-express:sync-cities 

#sync offices with database (use -h to view options)
php artisan dynamic-express:sync-offices 

#sync all nomenclatures with database (use -h to view options)
php artisan dynamic-express:sync-all

#get payments (use -h to view options)
php artisan dynamic-express:get-payments

#get dynamic express api status (use -h to view options)
php artisan dynamic-express:api-status

#track parcels (use -h to view options)
php artisan dynamic-express:track
```

Models
```php
CarrierDynamicExpressCountry
CarrierDynamicExpressCity
CarrierDynamicExpressOffice
CarrierDynamicExpressPayment
CarrierDynamicExpressApiStatus
CarrierDynamicExpressTracking
```

Events

```php
CarrierDynamicExpressTrackingEvent
CarrierDynamicExpressPaymentEvent
```

## Parcels Tracking

1. Subscribe to tracking event, you will recieve last tracking info, if tracking command is schduled

```php
Event::listen(function (CarrierDynamicExpressTrackingEvent $event) {
    echo $event->account;
    dd($event->tracking);
});
```

2. Before use of tracking command you need to create your own command and define setUp method

```bash
php artisan make:command TrackCarrierDynamicExpress
```

3. In app/Console/Commands/TrackCarrierDynamicExpress define your logic for parcels to be tracked

```php
use Gdinko\DynamicExpress\Commands\TrackCarrierDynamicExpressBase;

class TrackCarrierDynamicExpressSetup extends TrackCarrierDynamicExpressBase
{
    protected function setup()
    {
        //define parcel selection logic here
        // $this->parcels = [];
    }
}
```

4. Use the command

```bash
php artisan dynamic-express:track
```

## Examples

Calculate price
```php
$data = [

    // value is taken with getServices Method. Here 1 is ->
    // -> "Бързи градски услуги" (fast urban services)
    'service' => 1,

    // value is taken with getSubServices Method. ->
    // -> Here 18 is "48 часа икономична" (48h economical)
    'subservice' => 18,

    // 0(zero) or 1 (1 if there will be fixed delivery, 0 if not)
    'fix_chas' => 0,

    // 0(zero) or 1 (1 if there will be return reciept, 0 if not)
    'return_receipt' => 0,

    // 0(zero) or 1 (1 if there will be return document, 0 if not)
    'return_doc' => 0,

    // COD(cash on delivery). 0(zero) if there is no COD. ->
    // -> USE "."(dot) for decimals!
    'nal_platej' => 50,

    // Insurance Value. 0(zero) if there is no insurance. ->
    // -> USE "."(dot) for decimals!
    'zastrahovka' => 50,

    // Weigth in kg. CAN'T be 0(zero). Use "."(dot) for decimals.
    'teglo' => 2.5,

    // ID of the country(ISO standart). ->
    // -> Required only for international delivery
    'country_b' => 100,

];

$priceData = DynamicExpress::calculate($data);

dd($priceData);
```

You can use all methods from the WDSL Schema Like this:
```php
DynamicExpress::getMyObjectInfo();
DynamicExpress::getMyObjects();
DynamicExpress::getOfficesCity();
DynamicExpress::getOfficesCord(100);
DynamicExpress::getSoapCouriers();

//and so on , see the documentation
```

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