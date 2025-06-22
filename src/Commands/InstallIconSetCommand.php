<?php

namespace Guava\FilamentIcons\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Laravel\Prompts\Progress;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\multisearch;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

class InstallIconSetCommand extends Command
{
    private const PACKAGES = [
        'swapnilsarwe/blade-academicons' => 'Academicons',
        'swapnilsarwe/blade-akar-icons' => 'Akar Icons',
        'swapnilsarwe/blade-ant-design-icons' => 'Ant Design Icons',
        'davidhsianturi/blade-bootstrap-icons' => 'Bootstrap Icons',
        'danpock/blade-boxicons' => 'Boxicons',
        'swapnilsarwe/blade-bytesize-icons' => 'Bytesize Icons',
        'johanboshoff/blade-car-makes-icons' => 'Car Makes Icons',
        'swapnilsarwe/blade-carbon-icons' => 'Carbon Icons',
        'fahri-meral/blade-circle-flags' => 'Circle Flags',
        'swapnilsarwe/blade-clarity-icons' => 'Clarity Icons',
        'swapnilsarwe/blade-coolicons' => 'Coolicons',
        'adrianub/blade-coreui-icons' => 'CoreUI Icons',
        'stijnvanouplines/blade-country-flags' => 'Country Flags',
        'swapnilsarwe/blade-cryptocurrency-icons' => 'Cryptocurrency Icons',
        'khatabwedaa/blade-css-icons' => 'CSS Icons',
        'swapnilsarwe/blade-dev-icons' => 'Dev Icons',
        'swapnilsarwe/blade-element-plus-icons' => 'Element Plus Icons',
        'swapnilsarwe/blade-elusive-icons' => 'Elusive Icons',
        'swapnilsarwe/blade-emblemicons' => 'Emblemicons',
        'maiden-voyage/blade-emojis' => 'Emojis',
        'owenvoke/blade-entypo' => 'Entypo',
        'swapnilsarwe/blade-eos-icons' => 'EOS Icons',
        'nehalhasnayeen/blade-eva-icons' => 'Eva Icons',
        'swapnilsarwe/blade-evil-icons' => 'Evil Icons',
        'brunofalcao/blade-feather-icons' => 'Feather Icons',
        'swapnilsarwe/blade-file-icons' => 'File Icons',
        'brandon-nifong/blade-filetype-icons' => 'File Type Icons',
        'swapnilsarwe/blade-fluentui-system-icons' => 'FluentUI System Icons',
        'dominikethomas/blade-flowbite-icons' => 'Flowbite Icons',
        'swapnilsarwe/blade-font-audio' => 'Font Audio',
        'owenvoke/blade-fontawesome' => 'Font Awesome',
        'swapnilsarwe/blade-fontisto-icons' => 'Fontisto Icons',
        'swapnilsarwe/blade-fork-awesome' => 'Fork Awesome',
        'timjoosten/blade-github-octicons' => 'GitHub Octicons',
        'swapnilsarwe/blade-google-material-design-icons' => 'Google Material Design Icons',
        'swapnilsarwe/blade-gov-icons' => 'Gov Icons',
        'swapnilsarwe/blade-gravity-ui-icons' => 'Gravity UI Icons',
        'swapnilsarwe/blade-grommet-icons' => 'Grommet Icons',
        'giuliotroccoliallard/blade-health-icons' => 'Health Icons',
        'mustafaafat/blade-hugeicons' => 'Hugeicons',
        'swapnilsarwe/blade-humbleicons' => 'Humbleicons',
        'joesylnice/blade-icomoon-icons' => 'Icomoon Icons',
        'swapnilsarwe/blade-icon-park-icons' => 'Icon Park Icons',
        'malikjones/blade-iconic-icons' => 'Iconic Icons',
        'andreiionita/blade-iconoir' => 'Iconoir',
        'saade/blade-iconsax' => 'Iconsax',
        'swapnilsarwe/blade-ikonate-icons' => 'Ikonate Icons',
        'faisalahmed/blade-ionicons' => 'Ionicons',
        'mrdindar/blade-iranian-brands-icons' => 'Iranian Brands Icons',
        'swapnilsarwe/blade-jam-icons' => 'Jam Icons',
        'mansoorahmed/blade-lets-icons' => "Let's Icons",
        'swapnilsarwe/blade-line-awesome-icons' => 'Line Awesome Icons',
        'ngoduat/blade-lineicons' => 'Lineicons',
        'danpock/blade-lucide-icons' => 'Lucide Icons',
        'swapnilsarwe/blade-majestic-icons' => 'Majestic Icons',
        'swapnilsarwe/blade-maki-icons' => 'Maki Icons',
        'postare/blade-material-design-icons' => 'Material Design Icons',
        'swapnilsarwe/blade-memory-icons' => 'Memory Icons',
        'swapnilsarwe/blade-microns' => 'Microns',
        'swapnilsarwe/blade-mono-icons' => 'Mono Icons',
        'andriitrush/blade-payment-logos' => 'Payment Logos',
        'swapnilsarwe/blade-pepicons' => 'Pepicons',
        'swapnilsarwe/blade-phosphor-icons' => 'Phosphor Icons',
        'swapnilsarwe/blade-pixelarticons' => 'Pixelarticons',
        'samoilenkoeduard/blade-polaris-icons' => 'Polaris Icons',
        'swapnilsarwe/blade-prime-icons' => 'Prime Icons',
        'swapnilsarwe/blade-radix-icons' => 'Radix Icons',
        'andreiionita/blade-remix-icon' => 'Remix Icon',
        'swapnilsarwe/blade-rpg-awesome-icons' => 'RPG Awesome Icons',
        'adrianub/blade-simple-icons' => 'Simple Icons',
        'swapnilsarwe/blade-simple-line-icons' => 'Simple Line Icons',
        'swapnilsarwe/blade-solar-icons' => 'Solar Icons',
        'swapnilsarwe/blade-system-uicons' => 'System UIcons',
        'ryanchandler/blade-tabler-icons' => 'Tabler Icons',
        'swapnilsarwe/blade-teeny-icons' => 'Teeny Icons',
        'swapnilsarwe/blade-typicons' => 'Typicons',
        'swapnilsarwe/blade-uiw-icons' => 'UIW Icons',
        'swapnilsarwe/blade-unicons' => 'Unicons',
        'arthurmonney/blade-untitledui-icons' => 'Untitled UI Icons',
        'swapnilsarwe/blade-vaadin-icons' => 'Vaadin Icons',
        'swapnilsarwe/blade-vscode-codicons' => 'VSCode Codicons',
        'swapnilsarwe/blade-weather-icons' => 'Weather Icons',
        'swapnilsarwe/blade-zondicons' => 'Zondicons',
    ];

    public $signature = 'filament-icons:install';

    protected $aliases = [
        'icons:install',
    ];

    public $description = 'My command';

    public function handle(): void
    {
        $packages = multisearch(
            label: 'Select the icon packs that you would like to install',
            options: static fn (string $value) => strlen($value) > 0
                ?
                collect(static::PACKAGES)
                    ->filter(
                        fn (string $name, string $package) => str_contains($package, $value) || str_contains($name, $value)
                    )
                    ->all()
                : static::PACKAGES,
            required: true,
            scroll: 3
        );

        $result = progress(
            label: 'Checking packages...',
            steps: $packages,
            callback: function (string $package, Progress $progress): array {
                $progress
                    ->label("Checking $package...")
                ;

                return [
                    'package' => $package,
                    'success' => $this->checkIfPackageCanBeInstalled($package),
                ];
            }
        );

        table(
            headers: ['Package', 'Installable'],
            rows: array_map(
                static fn (array $item) => [
                    'package' => $item['package'],
                    'success' => $item['success'] ? '✅ Yes' : '❌ No',
                ],
                $result,
            )
        );

        $successfulPackages = array_filter($result, static fn (array $item) => $item['success']);
        $successfulPackagesCount = count($successfulPackages);

        if ($successfulPackagesCount > 0 && confirm('Do you want to proceed with the installation of [' . $successfulPackagesCount . '] packages?')) {
            $update = spin(
                message: 'Installing composer packages...',
                callback: function () use ($successfulPackages) {
                    foreach ($successfulPackages as $item) {
                        $package  = $item['package'];

                        Process::run(['composer', 'require', $package, '--no-update']);
                    }

                    return Process::run(['composer', 'update', '--no-interaction']);
                }
            );

            if ($update->successful()) {
                info('Installation successful');

                if (confirm('Do you want to generate icon enum classes for your installed packages?')) {
                    app(GenerateIconEnumClassCommand::class)->handle();
                }
            }

            error('Installation failed.');
        }
    }

    protected function checkIfPackageCanBeInstalled($package): bool
    {
        // Check if package can be installed
        $installationCheck = Process::run(['composer', 'require', $package, '--dry-run', '--no-interaction']);

        return $installationCheck->successful();
    }
}
