<?php

namespace Guava\FilamentIcons;

use Guava\FilamentIcons\Commands\GenerateIconEnumClassCommand;
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

        //            ->hasInstallCommand(function (InstallCommand $command) {
        //                $command
        //                    ->publishConfigFile()
        //                    ->publishMigrations()
        //                    ->askToRunMigrations()
        //                    ->askToStarRepoOnGitHub('guava/filament-icons');
        //            });
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Handle Stubs
        //        if (app()->runningInConsole()) {
        //            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
        //                $this->publishes([
        //                    $file->getRealPath() => base_path("stubs/filament-icons/{$file->getFilename()}"),
        //                ], 'filament-icons-stubs');
        //            }
        //        }
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            GenerateIconEnumClassCommand::class,
        ];
    }
}
