<x-filament-panels::page>

    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <br>
        <div style="text-align:center">
            {{ $this->aboutFormAction }}
        </div>


    </form>

</x-filament-panels::page>
