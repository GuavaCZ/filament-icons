<?php

namespace Guava\FilamentIcons\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Laravel\Prompts\Progress;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multisearch;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\table;

class InstallIconSetCommand extends Command
{
    private const PACKAGES = [
        'codeat3/blade-academicons' => 'Academicons',
        'codeat3/blade-akar-icons' => 'Akar Icons',
        'codeat3/blade-ant-design-icons' => 'Ant Design Icons',
        'davidhsianturi/blade-bootstrap-icons' => 'Bootstrap Icons',
        'mallardduck/blade-boxicons' => 'Boxicons',
        'codeat3/blade-bytesize-icons' => 'Bytesize Icons',
        'johan-boshoff/blade-car-makes-icons' => 'Car Makes Icons',
        'codeat3/blade-carbon-icons' => 'Carbon Icons',
        'smarteknoloji/blade-circle-flags' => 'Circle Flags',
        'codeat3/blade-clarity-icons' => 'Clarity Icons',
        'codeat3/blade-coolicons' => 'Coolicons',
        'ublabs/blade-coreui-icons' => 'CoreUI Icons',
        'stijnvanouplines/blade-country-flags' => 'Country Flags',
        'codeat3/blade-cryptocurrency-icons' => 'Cryptocurrency Icons',
        'khatabwedaa/blade-css-icons' => 'CSS Icons',
        'codeat3/blade-devicons' => 'Dev Icons',
        'codeat3/blade-element-plus-icons' => 'Element Plus Icons',
        'codeat3/blade-elusive-icons' => 'Elusive Icons',
        'codeat3/blade-emblemicons' => 'Emblemicons',
        'maiden-voyage-software/blade-emojis' => 'Emojis',
        'owenvoke/blade-entypo' => 'Entypo',
        'codeat3/blade-eos-icons' => 'EOS Icons',
        'hasnayeen/blade-eva-icons' => 'Eva Icons',
        'codeat3/blade-evil-icons' => 'Evil Icons',
        'brunocfalcao/blade-feather-icons' => 'Feather Icons',
        'codeat3/blade-file-icons' => 'File Icons',
        'log1x/blade-filetype-icons' => 'File Type Icons',
        'codeat3/blade-fluentui-system-icons' => 'FluentUI System Icons',
        'themesberg/flowbite-blade-icons' => 'Flowbite Icons',
        'codeat3/blade-fontaudio' => 'Font Audio',
        'owenvoke/blade-fontawesome' => 'Font Awesome',
        'codeat3/blade-fontisto-icons' => 'Fontisto Icons',
        'codeat3/blade-forkawesome' => 'Fork Awesome',
        'actb/blade-github-octicons' => 'GitHub Octicons',
        'codeat3/blade-google-material-design-icons' => 'Google Material Design Icons',
        'codeat3/blade-govicons' => 'Gov Icons',
        'codeat3/blade-gravity-ui-icons' => 'Gravity UI Icons',
        'codeat3/blade-grommet-icons' => 'Grommet Icons',
        'troccoli/blade-health-icons' => 'Health Icons',
        'afatmustafa/blade-hugeicons' => 'Hugeicons',
        'codeat3/blade-humbleicons' => 'Humbleicons',
        'nerdroid23/blade-icomoon' => 'Icomoon Icons',
        'codeat3/blade-iconpark' => 'Icon Park Icons',
        'itsmalikjones/blade-iconic' => 'Iconic Icons',
        'andreiio/blade-iconoir' => 'Iconoir',
        'saade/blade-iconsax' => 'Iconsax',
        'codeat3/blade-ikonate' => 'Ikonate Icons',
        'faisal50x/blade-ionicons' => 'Ionicons',
        'mrdindar/blade-iranian-brands-icons' => 'Iranian Brands Icons',
        'codeat3/blade-jam-icons' => 'Jam Icons',
        'mansoor/blade-lets-icons' => "Let's Icons",
        'codeat3/blade-line-awesome-icons' => 'Line Awesome Icons',
        'datlechin/blade-lineicons' => 'Lineicons',
        'mallardduck/blade-lucide-icons' => 'Lucide Icons',
        'codeat3/blade-majestic-icons' => 'Majestic Icons',
        'codeat3/blade-maki-icons' => 'Maki Icons',
        'postare/blade-mdi' => 'Material Design Icons',
        'codeat3/blade-memory-icons' => 'Memory Icons',
        'codeat3/blade-microns' => 'Microns',
        'codeat3/blade-mono-icons' => 'Mono Icons',
        'isapp/blade-payment-logos' => 'Payment Logos',
        'codeat3/blade-pepicons' => 'Pepicons',
        'codeat3/blade-phosphor-icons' => 'Phosphor Icons',
        'codeat3/blade-pixelarticons' => 'Pixelarticons',
        'eduard9969/blade-polaris-icons' => 'Polaris Icons',
        'codeat3/blade-prime-icons' => 'Prime Icons',
        'codeat3/blade-radix-icons' => 'Radix Icons',
        'andreiio/blade-remix-icon' => 'Remix Icon',
        'codeat3/blade-rpg-awesome-icons' => 'RPG Awesome Icons',
        'ublabs/blade-simple-icons' => 'Simple Icons',
        'codeat3/blade-simple-line-icons' => 'Simple Line Icons',
        'codeat3/blade-solar-icons' => 'Solar Icons',
        'codeat3/blade-system-uicons' => 'System UIcons',
        'secondnetwork/blade-tabler-icons' => 'Tabler Icons',
        'codeat3/blade-teeny-icons' => 'Teeny Icons',
        'codeat3/blade-typicons' => 'Typicons',
        'codeat3/blade-uiw-icons' => 'UIW Icons',
        'codeat3/blade-unicons' => 'Unicons',
        'mckenziearts/blade-untitledui-icons' => 'Untitled UI Icons',
        'codeat3/blade-vaadin-icons' => 'Vaadin Icons',
        'codeat3/blade-codicons' => 'VSCode Codicons',
        'codeat3/blade-weather-icons' => 'Weather Icons',
        'blade-ui-kit/blade-zondicons' => 'Zondicons',
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
                        $package = $item['package'];

                        Process::run(['composer', 'require', $package, '--no-update']);
                    }

                    return Process::run(['composer', 'update', '--no-interaction']);
                }
            );

            if ($update->successful()) {
                info('Icon packs installed successfully.');
            } else {
                error('Installation failed.');
            }
        }
    }

    protected function checkIfPackageCanBeInstalled($package): bool
    {
        // Check if package can be installed
        $installationCheck = Process::run(['composer', 'require', $package, '--dry-run', '--no-interaction']);

        return $installationCheck->successful();
    }
}
