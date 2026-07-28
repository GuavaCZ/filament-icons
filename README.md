![filament-icons Banner](https://github.com/GuavaCZ/filament-icons/raw/main/.github/banner.png)

# Enum classes for any blade icon set

[![Latest Version on Packagist](https://img.shields.io/packagist/v/guava/filament-icons.svg?style=flat-square)](https://packagist.org/packages/guava/filament-icons)
[![Total Downloads](https://img.shields.io/packagist/dt/guava/filament-icons.svg?style=flat-square)](https://packagist.org/packages/guava/filament-icons)

This package generates typed enum classes for ANY blade icon set you have installed, making working with them a breeze. The generated enums implement filament's `ScalableIcon` contract, so you can use them anywhere filament accepts an icon, with full autocompletion.

In addition, it ships a command that lets you pick blade icon packs from a searchable list and installs them via composer.

## Documentation

The full documentation is available at [guava.cz](https://guava.cz/developers/packages/filament-icons), and in the [`docs`](docs) directory of this repository.

## Version compatibility

| Filament version | Plugin version |
|------------------|:--------------:|
| 4.x              |      1.x       |
| 5.x              |      1.x       |

## Installation

You can install the package via composer:

```bash
composer require guava/filament-icons
```

## Usage

Generate an enum for any installed icon set:

```bash
php artisan filament-icons:generate
```

Install icon packs from a searchable list:

```bash
php artisan filament-icons:install
```

Then use the generated enum anywhere filament accepts an icon:

```php
use App\Enums\Icons\Feather;

IconColumn::make('status')
    ->icon(Feather::Activity);
```

Everything else is covered in the [documentation](docs/1.x/01-introduction.md).

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Lukas Frey](https://github.com/lukas-frey)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
