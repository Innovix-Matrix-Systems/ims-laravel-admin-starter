<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Widgets\AccountWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Settings extends Page
{
    protected static string $view = 'filament.pages.settings';
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationLabel = 'Profile Settings';
    protected ?string $heading = 'Profile Settings';

    protected function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,
        ];
    }

    public function mount(): void
    {
        $this->form->fill([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ]);
        $this->userId = Auth::user()->id;
    }

    public $name;
    public $email;
    public $userId;

    public $password;
    public $password_confirmation;

    public function aboutFormAction()
    {
        return  Action::make('save profile information')
            ->label('Save')
            ->action('saveProfile')
            ->color('primary');
    }

    public function saveProfile(): void
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->userId . ',id',
            'password' => 'sometimes|nullable|min:6|confirmed',
            'password_confirmation' => 'sometimes|nullable|min:6|required_with:password',
        ]);

        try {
            $user = User::find($this->userId);
            $user->name = $this->name;
            $user->email = $this->email;
            if (!empty($this->password)) {
                $user->password = Hash::make($this->password);
            }
            $user->save();

            Notification::make()
                ->title('Saved successfully')
                ->success()
                ->send();
        } catch (\Throwable $th) {
            //throw $th;
            Notification::make()
                ->title('Failed to update profile')
                ->danger()
                ->send();
        }
    }

    public function Form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("About")
                    ->description('Settings for Account')
                    ->schema([
                        TextInput::make('name'),
                        TextInput::make('email'),
                    ])->columns(2),
                Section::make("Password")
                    ->description("Update Your Password. Keep empty if you don't want to change password")
                    ->schema([
                        TextInput::make('password')->password()->autocomplete(false),
                        TextInput::make('password_confirmation')->password(),
                    ])->columns(2),
            ]);
    }
}
