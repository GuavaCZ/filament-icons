<?php

namespace Guava\FilamentIcons;

use Guava\FilamentIcons\Commands\GenerateIconEnumClassCommand;
use Guava\FilamentIcons\Commands\InstallIconSetCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentIconsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-icons';

    public static string $viewNamespace = 'filament-icons';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
        ;
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            GenerateIconEnumClassCommand::class,
            InstallIconSetCommand::class
        ];
    }
}
