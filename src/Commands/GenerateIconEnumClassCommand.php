<?php

namespace Guava\FilamentIcons\Commands;

use BladeUI\Icons\Factory as IconFactory;
use Filament\Support\Enums\IconSize;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use SplFileInfo;

use function Laravel\Prompts\multiselect;

class GenerateIconEnumClassCommand extends Command
{
    public $signature = 'filament-icons:generate';

    public function __construct(
        protected Filesystem $files,
        protected IconFactory $iconFactory
    ) {
        parent::__construct();
    }

    protected $aliases = [
        'filament:icons',
    ];

    public $description = 'My command';

    public function handle(): int
    {
        $sets = $this->iconFactory->all();

        $selectedSetIds = multiselect(
            label: 'Select the icon sets for which you would like to generate an enum class',
            options: array_keys($sets),
        );

        foreach ($selectedSetIds as $setId) {
            $set = $sets[$setId];
            $prefix = data_get($set, 'prefix');
            $paths = data_get($set, 'paths') ?? [];

            $icons = collect();
            foreach ($paths as $path) {
                /** @var SplFileInfo $file */
                $names = collect(File::allFiles($path))
                    ->map(
                        static fn (SplFileInfo $file): string => str($file->getFilename())->beforeLast('.')
                    )
                ;
                $icons->put($prefix, $names);
            }

            foreach ($icons as $prefix => $names) {
                $namespace = 'App\\Enums\\Icons';
                $className = str($setId)->pascal()->toString();
                $cases = collect($names)
                    ->map(
                        static fn (string $name): string => str("\tcase ")
                            ->append(str($name)->pascal())
                            ->append(' = ', "'$name'", ';')
                    )
                    ->join("\n")
                ;
                $class = <<<PHP
<?php
namespace $namespace;

use Filament\Support\Contracts\ScalableIcon;
use Filament\Support\Enums\IconSize;

enum $className: string implements ScalableIcon
{
$cases

    public function getIconForSize(IconSize \$size): string
    {
        return match (\$size) {
            default => "$prefix-\$this->value",
        };
    }
}
PHP;

                //                dd(str($class)->limit(300));
                $targetPath = base_path('app/Enums/Icons/' . $className . '.php');
                $this->makeDirectory($targetPath);
                                $this->files->put(
                                    $targetPath,
                                    $class
                                );

            }
        }

        $this->comment('All done');

        return self::SUCCESS;
    }

    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }
}
