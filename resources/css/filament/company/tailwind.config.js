import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Company/**/*.php',
        './resources/views/filament/company/**/*.blade.php',
        './resources/views/components/company/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/andrewdwallo/filament-companies/resources/views/**/*.blade.php',
        './vendor/andrewdwallo/filament-selectify/resources/views/**/*.blade.php',
        './vendor/bezhansalleh/filament-panel-switch/resources/views/panel-switch-menu.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                white: '#F6F5F3',
            },
        }
    }
}
