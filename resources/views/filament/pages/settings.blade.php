<x-filament-panels::page>
    <div>
        {{$this->updateSystemSettingsForm}}
        <br>
        <div style="text-align:center">
            {{$this->saveSettingsAction}}
        </div>

        <br>
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
