<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    File::deleteDirectory(app_path('Enums'));
});

it('generates an enum class for an installed icon set', function () {
    $this->artisan('filament-icons:generate')
        ->expectsQuestion('Select the icon sets for which you would like to generate an enum class', ['feather-icons'])
        ->expectsQuestion('Choose the namespace for the icon enums', 'Enums\Icons')
        ->expectsQuestion('Choose the enum class name for the icon set: [feather-icons]', 'Feather')
        ->assertSuccessful()
    ;

    $path = app_path('Enums/Icons/Feather.php');

    expect(File::exists($path))->toBeTrue();

    $contents = File::get($path);

    expect($contents)
        ->toContain('namespace App\Enums\Icons;')
        ->toContain('enum Feather: string implements ScalableIcon')
        ->toContain("case Activity = 'activity';")
        ->toContain('"feathericon-$this->value"')
    ;
});

it('skips the built in filament sets', function () {
    // Only feather is installed on top of the defaults, so heroicons and
    // filament's own set must not be offered.
    $this->artisan('filament-icons:generate')
        ->expectsQuestion('Select the icon sets for which you would like to generate an enum class', ['feather-icons'])
        ->expectsQuestion('Choose the namespace for the icon enums', 'Enums\Icons')
        ->expectsQuestion('Choose the enum class name for the icon set: [feather-icons]', 'Feather')
        ->assertSuccessful()
    ;

    expect(File::exists(app_path('Enums/Icons/Heroicons.php')))->toBeFalse();
});
