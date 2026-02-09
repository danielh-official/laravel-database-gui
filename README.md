# Laravel Database GUI

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danielh-official/laravel-database-gui.svg?style=flat-square)](https://packagist.org/packages/danielh-official/laravel-database-gui)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/danielh-official/laravel-database-gui/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/danielh-official/laravel-database-gui/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/danielh-official/laravel-database-gui/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/danielh-official/laravel-database-gui/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/danielh-official/laravel-database-gui.svg?style=flat-square)](https://packagist.org/packages/danielh-official/laravel-database-gui)

An in-app GUI for performing local database operations in your Laravel application. Like TablePlus, but in your app.

![](./docs/screenshots/sample.png)

## Installation

You can install the package via composer:

```bash
composer require --dev danielh-official/laravel-database-gui
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="database-gui-config"
```

This is the contents of the published config file:

```php
return [
    'base_path' => 'db', // The base path for your database GUI routes
    'app_path' => '/', // The path back to your main app
];
```

<b>Note</b>: This project uses Tailwind for styling. You have the following options:

- Include Tailwind in your project if you haven't already.
- Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="database-gui-views"
```

And then style or change them however you like.

## Usage

<b>This package is meant to be used in a local environment only.</b>

Routes are auto-registered in the local environment by default.

Run `php artisan route:list` to see the list of routes for your app.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Daniel Haven](https://github.com/danielh-official)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
