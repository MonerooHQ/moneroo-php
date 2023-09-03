<div align="center">
<a href="https://moneroo.io" title="Moneroo - Payment stack for Africa">
    <img src="/art/cover.svg" alt="Moneroo website">
</a>

# Moneroo PHP SDK

<!-- Nav header - Start -->

<a href="https://join.slack.com/t/ballerine-oss/shared_invite/zt-1iu6otkok-OqBF3TrcpUmFd9oUjNs2iw">Slack</a>
·
<a href="https://www.moneroo.io/">Website</a>
·
<a href="https://www.moneroo.io/contact">Contact</a>
·
<a href="https://docs.moneroo.io/">Documentation</a>

<!-- Nav header - END -->

<!-- Badges - Start -->
[![PHP Version](https://img.shields.io/packagist/php-v/moneroo/moneroo-php.svg)](https://packagist.org/packages/moneroo/moneroo-php)
[![Build Status](https://github.com/monerooHQ/moneroo-php/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/moneroo/moneroo-php/actions?query=branch%3Amain)
[![Latest Stable Version](https://poser.pugx.org/moneroo/moneroo-php/v/stable.svg)](https://packagist.org/packages/moneroo/moneroo-php)
[![Total Downloads](https://poser.pugx.org/moneroo/moneroo-php/downloads.svg)](https://packagist.org/packages/moneroo/moneroo-php)
[![License](https://poser.pugx.org/moneroo/moneroo-php/license.svg)](https://packagist.org/packages/moneroo/moneroo-php)

<!-- Badges - END -->


</div>

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
You can set `devMode` to `true` when creating a new instance of the SDK to enable the dev mode.
After enabling the dev mode, you can pass `devBaseUrl` to customize the base URL of the Moneroo API you want to use.
In dev mode, the SDK will use the `devBaseUrl` instead of the default base URL `https://api.moneroo.io`.

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
