---
title: Introduction
---

# Introduction

Icons is a small command line companion for working with [blade-icons](https://github.com/driesvints/blade-icons) sets in filament.

Filament ships heroicons as a typed `Heroicon` enum, which gives you autocompletion and typo safety. Any other icon set only exists as strings like `'feathericon-activity'`. This package closes that gap with two artisan commands:

- `filament-icons:generate` generates an enum class for any installed blade icon set, implementing filament's `ScalableIcon` contract, so you can use it anywhere filament accepts an icon.
- `filament-icons:install` lets you pick blade icon packs from a searchable list and installs them via composer.

A generated enum looks like this and works anywhere filament accepts an icon:

```php
use App\Enums\Icons\Feather;

IconColumn::make('status')
    ->icon(Feather::Activity);
```
