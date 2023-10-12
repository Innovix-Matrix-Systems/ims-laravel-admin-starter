<x-filament-panels::page>
    <div>
        {{ $this->updateProfileFrom }}
        <br>
        <div style="text-align:center">
            {{ $this->saveProfileAction }}
        </div>
        <br>
        {{ $this->updatePasswordForm }}
        <br>
        <div style="text-align:center">
            {{ $this->savePasswordAction }}
        </div>
    </div>
</x-filament-panels::page>
