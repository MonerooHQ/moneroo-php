
# Moneroo PHP SDK

[![Build Status](https://github.com/moneroo/moneroo-php/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/moneroo/moneroo-php/actions?query=branch%3Amain)
[![Latest Stable Version](https://poser.pugx.org/moneroo/moneroo-php/v/stable.svg)](https://packagist.org/packages/moneroo/moneroo-php)
[![Total Downloads](https://poser.pugx.org/moneroo/moneroo-php/downloads.svg)](https://packagist.org/packages/moneroo/moneroo-php)
[![License](https://poser.pugx.org/moneroo/moneroo-php/license.svg)](https://packagist.org/packages/moneroo/moneroo-php)

The Moneroo PHP SDK provides convenient access to the Moneroo API from applications written with PHP.


## Requirements
PHP Requirements: PHP 7.4 and later.

## Installation

You can install the package via composer:

```shell
composer require moneroo/moneroo-php
```

## Documentation
See the php SDK [documentation](https://docs.moneroo.io/sdk/php).

## Development

1- Perform the tests
```shell
 composer test
```
2- Format and analyze your code before commit and push.
```shell
 composer format # Format your code with the required code style
 composer unused # check if there is an unused dependency
composer analyze # Analyze your code with phpstan
```

### DEV Mode
You can set (or add) `moneroo.devMode` to `true` in your `config/moneroo.php` file to enable the dev mode.
After enabling the dev mode, you can set `moneroo.devBaseUrl` to customize the base URL of the Moneroo API you want to use.
In dev mode, the SDK will use the `moneroo.devBaseUrl` instead of the default base URL `https://api.moneroo.io`.

## Notes
- The project is based on the KISS principle.
- Each time you make a change, you must run the tests and format your code.
- Each time you make a change, you must update the documentation.
- Each time you make a change, you must update the changelog.
- Each time you make a change, you must add test cases.
- Each time you make a change, you must update the version number.
- Each time you make a change, you must update the API documentation.
- Each time you make a change, you must update the README.md file.

## Security Vulnerabilities
If you discover a security vulnerability within Moneroo php SDK, please send an e-mail to Moneroo Security via [hello@moneroo.io](mailto:security@moneroo.io). All security vulnerabilities will be promptly addressed.

## License

The Moneroo PHP SDK is open-sourced software licensed under the [MIT license](LICENSE.md).
