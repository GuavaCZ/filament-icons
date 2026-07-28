<?php

namespace Workbench\App\Filament\Pages;

use Filament\Pages\Page;
use Workbench\App\Enums\Feather;

/**
 * Renders every case of the generated Feather enum, so a change to the stub or
 * the generator is immediately visible. The enum itself is real output of
 * `filament-icons:generate`, only moved into the Workbench namespace.
 */
class IconsDemo extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = Feather::Feather;

    protected static ?string $navigationLabel = 'Generated icons';

    protected static ?string $title = 'Generated icons';

    protected static ?string $slug = 'icons';

    protected string $view = 'workbench::filament.pages.icons-demo';

    /**
     * @return array<int, Feather>
     */
    public function getIcons(): array
    {
        return Feather::cases();
    }
}
