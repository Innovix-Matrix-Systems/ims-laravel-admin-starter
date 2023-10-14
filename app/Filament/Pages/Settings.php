<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Widgets\AccountWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.pages.settings';
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 3;
    //protected static ?string $navigationLabel = 'Profile Settings';
    //protected ?string $heading = 'Profile Settings';
    public static function getNavigationLabel(): string
    {
        return __('pages.profile.settings');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            //AccountWidget::class,
        ];
    }

    protected function getForms(): array
    {
        return [
            'updateSystemSettingsForm',
            'updateProfileFrom',
            'updatePasswordForm',
        ];
    }

    public $name;
    public $email;
    public $userId;

    public $password;
    public $password_confirmation;

    public $language;

    public function mount(): void
    {
        $this->updateProfileFrom->fill([
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ]);
        $this->userId = Auth::user()->id;
        $this->language = session('locale', config('app.locale'));
    }

    public function saveProfileAction()
    {
        return  Action::make('save profile information')
            ->label(__('pages.profile.action.label'))
            ->action('saveProfile')
            ->color('primary');
    }

    public function savePasswordAction()
    {
        return  Action::make('update password')
            ->label(__('pages.profile.action.password.label'))
            ->action('updatePassword')
            ->color('primary');
    }

    public function saveSettingsAction()
    {
        return  Action::make('update system settings')
            ->label(__('pages.system.action.label'))
            ->action('updateSettings')
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
                ->title(__('notifications.save.success'))
                ->success()
                ->send();
        } catch (\Throwable $th) {
            //throw $th;
            Notification::make()
                ->title(__('notifications.profile.save.failed'))
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
                ->title(__('notifications.profile.password.save.success'))
                ->success()
                ->send()
                ->sendToDatabase(Auth::user());
        } catch (\Throwable $th) {
            //throw $th;
            Notification::make()
                ->title(__('notifications.profile.save.failed'))
                ->danger()
                ->send();
        }
    }

    public function updateSettings()
    {
        $this->validate([
            'language' => 'required|string',
        ]);

        try {
            session()->put('locale', $this->language);
            app()->setLocale($this->language);
            Carbon::setLocale($this->language);

            Notification::make()
                ->title(__('notifications.save.success'))
                ->success()
                ->send()
                ->sendToDatabase(Auth::user());

            return redirect('/admin');
        } catch (\Throwable $th) {
            //throw $th;
            Notification::make()
                ->title(__('notifications.profile.save.failed'))
                ->danger()
                ->send();
        }

    }

    public function updatePasswordForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('pages.profile.password'))
                    ->description(__('pages.profile.update_password'))
                    ->schema([
                        TextInput::make('password')
                        ->label(__('pages.profile.form.label.password'))
                        ->password()
                        ->autocomplete(false),
                        TextInput::make('password_confirmation')
                        ->label(__('pages.profile.form.label.password_confirmed'))
                        ->password(),
                    ])->columns(2),
            ]);
    }

    public function updateProfileFrom(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('pages.profile.account_information'))
                    ->description(__('pages.profile.account_settings'))
                    ->schema([
                        TextInput::make('name')
                        ->label(__('pages.profile.form.label.name')),
                        TextInput::make('email')
                        ->label(__('pages.profile.form.label.email')),
                    ])->columns(2),
            ]);
    }

    public function updateSystemSettingsForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('pages.system.settings'))
                    ->description(__('pages.system.settings.desc'))
                    ->schema([
                        Select::make('language')
                            ->label(__('pages.system.settings.language'))
                            ->options($this->getLanguageOptions())
                            ->native(false)
                            ->reactive()
                            ->required()
                            ->default('en'),
                    ])->columns(1),
            ]);
    }

    private function getLanguageOptions(): array
    {
        return [
            'en' => 'English',
            'bn' => 'Bangla(বাংলা)',
        ];
    }
}
