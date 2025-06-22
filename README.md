# This package allows you to generate enum classes for ANY blade icon set you have installed, making working with them a breeze!

[![Latest Version on Packagist](https://img.shields.io/packagist/v/guava/filament-icons.svg?style=flat-square)](https://packagist.org/packages/guava/filament-icons)

[//]: # ([![GitHub Tests Action Status]&#40;https://img.shields.io/github/actions/workflow/status/guavaCZ/filament-icons/run-tests.yml?branch=main&label=tests&style=flat-square&#41;]&#40;https://github.com/guava/filament-icons/actions?query=workflow%3Arun-tests+branch%3Amain&#41;)
[//]: # ([![GitHub Code Style Action Status]&#40;https://img.shields.io/github/actions/workflow/status/guava/filament-icons/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square&#41;]&#40;https://github.com/guava/filament-icons/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain&#41;)
[![Total Downloads](https://img.shields.io/packagist/dt/guava/filament-icons.svg?style=flat-square)](https://packagist.org/packages/guava/filament-icons)


This package allows you to generate enum classes for ANY blade icon set you have installed, making working with them a breeze!

## Installation

You can install the package via composer:

```bash
composer require guava/filament-icons
```

## Usage

Using the package is dead simple! There are two commands that you can run.

### Generate Icon Enum

```bash
php artisan filament-icons:generate
```
Simply run the command follow the instructions to generate a complete Enum class for any of your blade icon sets, even your custom ones!

### Installing blade icon packs
If you do not have any blade icon packs installed, you can use the convenient install command which simply allows you to select and download one of the many blade icon packs found [here](https://github.com/driesvints/blade-icons#icon-packages).

```bash
php artisan filament-icons:install
```

It is not necessary to run this command if you already have some blade icon packs installed.

#### Icon packs list
The icon packs available for download are taken from the blade icons package [here](https://github.com/driesvints/blade-icons#icon-packages).

If you find that some of the icon packs available for installation are outdated, or if you know of an icon pack that is not available to download via the command and you would like to add it, feel free to PR an addition to the `PACKAGES` constant in the `InstallIconPackCommand` or create an issue with the composer package name and link to the github repository.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Lukas Frey](https://github.com/GuavaCZ)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
