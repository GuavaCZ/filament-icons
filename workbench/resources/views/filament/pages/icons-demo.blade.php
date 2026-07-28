<x-filament-panels::page>
    {{-- Inline styles on purpose: the workbench uses filament's precompiled theme,
         so arbitrary tailwind utilities would not be part of the CSS build. --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(9rem, 1fr)); gap: 0.75rem;">
        @foreach ($this->getIcons() as $icon)
            <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem; padding: 1rem; border-radius: 0.5rem; border: 1px solid rgba(128, 128, 128, 0.25);">
                <x-filament::icon :icon="$icon" style="width: 1.5rem; height: 1.5rem;" />
                <span style="font-size: 0.75rem; opacity: 0.6;">{{ $icon->value }}</span>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
