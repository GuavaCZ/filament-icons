---
title: Generating enums
---

# Generating enums

Run the generate command and follow the prompts:

```bash
php artisan filament-icons:generate
```

The command lists every installed blade icon set except the built in heroicons and filament sets, which already ship as filament's `Heroicon` enum. For each selected set you choose a namespace (`App\Enums\Icons` by default) and a class name, and the command writes an enum with one case per icon:

```php
namespace App\Enums\Icons;

use Filament\Support\Contracts\ScalableIcon;
use Filament\Support\Enums\IconSize;

enum Feather: string implements ScalableIcon
{
    case Activity = 'activity';
    case Airplay = 'airplay';
    // ... one case per icon in the set

    public function getIconForSize(IconSize $size): string
    {
        return match ($size) {
            default => "feathericon-$this->value",
        };
    }
}
```

Because the enum implements `ScalableIcon`, you can use it anywhere filament accepts an icon: navigation icons, columns, actions, form field affixes and so on.

```php
use App\Enums\Icons\Feather;

protected static string | BackedEnum | null $navigationIcon = Feather::Compass;
```

If an icon set receives new icons, simply run the command again to regenerate the enum.

## Custom sets

Custom sets registered with blade-icons, for example your own SVG directory, show up in the list like any other set, so you can generate typed enums for your own icons too.
