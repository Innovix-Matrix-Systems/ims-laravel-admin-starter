<x-filament-panels::page>
    <x-filament-panels::form>
        {{ $this->updateSystemSettingsForm }}
        <div>
            {{ $this->saveSettingsAction }}
        </div>
        {{ $this->updateProfileFrom }}
        <div>
            {{ $this->saveProfileAction }}
        </div>
        {{ $this->updatePasswordForm }}
        <div>
            {{ $this->savePasswordAction }}
        </div>
    </x-filament-panels::form>
    </x-filament-panels::form>
