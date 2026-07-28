---
title: Installing icon packs
---

# Installing icon packs

If you don't have any blade icon packs installed yet, the install command lets you pick them from a searchable list of the packs found in the [blade-icons readme](https://github.com/driesvints/blade-icons#icon-packages):

```bash
php artisan filament-icons:install
```

The command first checks which of your selected packs can be installed into your project, shows you the result, and then installs them via composer in one go.

After installing packs, don't forget to cache the icon manifest:

```bash
php artisan icons:cache
```

## Outdated list?

The list of packs is maintained by hand in the `InstallIconSetCommand::PACKAGES` constant. If you find a pack missing or outdated, a PR is very welcome.
