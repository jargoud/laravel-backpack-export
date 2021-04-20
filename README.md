# Laravel Backpack Export

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jargoud/laravel-backpack-export.svg?style=flat-square)](https://packagist.org/packages/jargoud/laravel-backpack-export)
[![Build Status](https://img.shields.io/travis/jargoud/laravel-backpack-export/master.svg?style=flat-square)](https://travis-ci.org/jargoud/laravel-backpack-export)
[![Quality Score](https://img.shields.io/scrutinizer/g/jargoud/laravel-backpack-export.svg?style=flat-square)](https://scrutinizer-ci.com/g/jargoud/laravel-backpack-export)
[![Total Downloads](https://img.shields.io/packagist/dt/jargoud/laravel-backpack-export.svg?style=flat-square)](https://packagist.org/packages/jargoud/laravel-backpack-export)

This package provides a convenient way to export in [Laravel Backpack](https://backpackforlaravel.com/) CRUDs
with [Laravel Excel](https://laravel-excel.com/).

It provides a custom writer which allows to directly write on `php://stdout`.

## Installation

You can install the package via composer:

```bash
composer config repositories.laravel-backpack-export vcs https://github.com/jargoud/laravel-backpack-export.git
composer require jargoud/laravel-backpack-export
```

## Usage

Use [ExportOperation](./src/Http/Controllers/Operations/ExportOperation.php) trait in your CRUD controller and implement
the abstract method, for example:

``` php
protected function getExportClass(): UsersExport
{
    return new UsersExport();
}
```

The export class can be generated with the following command:

```bash
php artisan make:export UsersExport --model=User
```

For further information about export classes, please referer
to [the package's documentation](https://docs.laravel-excel.com/3.1/exports/).

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email jeremy.argoud@gmail.com instead of using the issue tracker.

## Credits

- [Jeremy Argoud](https://github.com/jargoud)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
