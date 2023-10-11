<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Widgets\AccountWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;
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

    protected function getForms(): array
    {
        return [
            'updateProfileFrom',
            'updatePasswordForm',
        ];
    }

    public $name;
    public $email;
    public $userId;

    public $password;
    public $password_confirmation;

    public function mount(): void
    {
        $this->updateProfileFrom->fill([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ]);
        $this->userId = Auth::user()->id;
    }

    public function saveProfileAction()
    {
        return  Action::make('save profile information')
            ->label('Save')
            ->action('saveProfile')
            ->color('primary');
    }

    public function savePasswordAction()
    {
        return  Action::make('update password')
            ->label('Update Password')
            ->action('updatePassword')
            ->color('primary');
    }

    public function saveProfile(): void
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->userId . ',id',
        ]);

        try {
            $user = Auth::user();
            $user->name = $this->name;
            $user->email = $this->email;
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

    public function updatePassword(): void
    {
        $this->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required_with:password|min:6',
        ]);

        try {
            $user = Auth::user();
            $user->password = Hash::make($this->password);
            $user->save();

            Notification::make()
                ->title('Password Updated Successfully')
                ->success()
                ->send();
        } catch (\Throwable $th) {
            //throw $th;
            Notification::make()
                ->title('Failed to update password')
                ->danger()
                ->send();
        }
    }

    public function updatePasswordForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Password")
                    ->description("Update Your Password")
                    ->schema([
                        TextInput::make('password')->password()->autocomplete(false),
                        TextInput::make('password_confirmation')->password(),
                    ])->columns(2),
            ]);
    }

    public function updateProfileFrom(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("About")
                    ->description('Settings for Account')
                    ->schema([
                        TextInput::make('name'),
                        TextInput::make('email'),
                    ])->columns(2),
            ]);
    }
}
