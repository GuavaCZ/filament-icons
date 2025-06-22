<?php

namespace Guava\FilamentIcons\Commands;

use BladeUI\Icons\Factory as IconFactory;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Stringable;
use SplFileInfo;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\text;

class GenerateIconEnumClassCommand extends GeneratorCommand
{
    public $signature = 'filament-icons:generate';

    protected IconFactory $iconFactory;

    protected $aliases = [
        'filament:icons',
        'icons:generate',
    ];

    public $description = 'My command';

    protected array $generationData = [];

    public function __construct(Filesystem $files, IconFactory $iconFactory)
    {
        $this->iconFactory = $iconFactory;
        parent::__construct($files);

    }

    public function handle(): int
    {
        $sets = $this->iconFactory->all();

        // Skip built in sets from filament
        unset($sets['heroicons']);
        unset($sets['filament']);

        if (empty($sets)) {
            error('There are no available icon sets to generate Enum classes for.');

            if (confirm('Would you like to install an icon package?')) {
                app(InstallIconSetCommand::class)->handle();
            }

            return 1;
        }

        $selectedSetIds = multiselect(
            label: 'Select the icon sets for which you would like to generate an enum class',
            options: array_keys($sets),
            required: true
        );

        $defaultNamespace = 'Enums\\Icons';
        $namespace = text(
            label: 'Choose the namespace for the icon enums',
            placeholder: 'App\\Enums\\Icons (Enter for default)'
        );
        if (empty($namespace)) {
            $namespace = $defaultNamespace;
        }
        data_set($this->generationData, 'namespace', $namespace);

        foreach ($selectedSetIds as $setId) {
            $defaultClassName = str($setId)->pascal()->toString();
            $className = text(
                label: 'Choose the enum class name for the icon set: [' . $setId . ']',
                placeholder: $defaultClassName . ' (Enter for default)'
            );
            if (empty($className)) {
                $className = $defaultClassName;
            }
            data_set($this->generationData, "classes.$setId", $className);
        }

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
                $cases = collect($names)
                    ->map(
                        static fn (string $name): string => str("\tcase ")
                            ->append(
                                str($name)
                                    ->pascal()
                                    ->when(
                                        fn (string $value) => preg_match('/^[0-9]/', $value),
                                        fn (Stringable $string) => $string->prepend('_')
                                    )
                            )
                            ->append(' = ', "'$name'", ';')
                    )
                    ->join("\n")
                ;

                data_set($this->generationData, 'current', $setId);
                $class = $this->qualifyClass($this->getNameInput());
                $result = spin(
                    message: 'Generating ' . $class,
                    callback: function () use ($prefix, $cases) {
                        $result = parent::handle();
                        $this->replaceCustomPlaceholders($cases, $prefix);

                        return $result;
                    }
                );
            }
        }

        $this->comment('Generation completed.');

        return self::SUCCESS;
    }

    protected function makeDirectory($path): string
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    protected function getStub(): string
    {
        return __DIR__ . '/../../stubs/IconEnum.php.stub';
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        $namespace = data_get($this->generationData, 'namespace');

        if (! $namespace) {
            $this->error('Namespace is missing');
            exit();
        }

        return str($namespace)
            ->ltrim($rootNamespace)
            ->ltrim('\\')
            ->prepend($rootNamespace, '\\')
        ;
    }

    protected function getNameInput()
    {
        $current = data_get($this->generationData, 'current');
        $name = data_get($this->generationData, "classes.$current");

        if (! $current || ! $name) {
            $this->error('An error occurred, try again. If the error persists, please contact the plugin author.');
            exit();
        }

        return $name;
    }

    protected function replaceCustomPlaceholders(string $cases, string $prefix): void
    {
        // Get the fully qualified class name (FQN)
        $class = $this->qualifyClass($this->getNameInput());

        // get the destination path, based on the default namespace
        $path = $this->getPath($class);

        $content = str(file_get_contents($path))
            ->replace('DummyCases', $cases)
            ->replace('DummyPrefix', $prefix)
        ;

        // Update the file content with additional data (regular expressions)

        file_put_contents($path, $content);
    }
}
