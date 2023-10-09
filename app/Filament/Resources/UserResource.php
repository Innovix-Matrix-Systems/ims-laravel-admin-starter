<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->with('roles.permissions', 'permissions');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->visibleOn('edit'),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required(fn (Page $livewire) => ($livewire instanceof CreateUser))
                            ->maxLength(255)
                            ->visible(function ($record) {
                                if (!$record) {
                                    return true;
                                }
                                return !$record->isSuperAdmin();
                            })
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state)),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->disabled(function ($record) {
                                if (!$record) {
                                    return false;
                                }
                                return $record->isSuperAdmin();
                            }),
                            Forms\Components\Select::make('roles')
                            ->multiple()
                            ->searchable()
                            ->relationship('roles', 'name', function (Role $role) {
                                return $role::where('id', '!=', 1);
                            })
                            ->preload(),
                    ])->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                // ->visible(false),
                Tables\Columns\IconColumn::make('is_active')
                    ->label("Active")
                    ->boolean(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->disabled(fn (User $record) => $record->isSuperAdmin() || !Auth::user()->hasPermissionTo('user.update')),
                Tables\Columns\TextColumn::make('roles')
                    ->badge()
                    ->state(function (User $record) {
                        return $record->getRoleNames();
                    }),
                    // ->color(fn (string $state): string => match ($state) {
                    //     'Super-Admin' => 'success',
                    //     'Admin' => 'info',
                    // }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Filter::make('View Only Active Users')
                    ->query(fn (Builder $query) => $query->where('is_active', true)),
                // SelectFilter::make('is_active')
                //     ->options([
                //         '1' => 'Active',
                //         '0' => 'Deactive',
                //     ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->visible(fn (User $record) => !$record->isSuperAdmin()),
                // Action::make('delete')
                //     ->requiresConfirmation()
                //     ->icon('heroicon-o-trash')
                //     ->color('danger')
                //     ->action(fn (User $record) => $record->delete())
                //     ->visible(fn (User $record) => !$record->isSuperAdmin() && Auth::user()->hasPermissionTo('user.delete'))
                //     ->modalHeading('Delete User')
                //     ->modalDescription('Are you sure you\'d like to delete this User? This cannot be undone.')
                //     ->modalSubmitActionLabel('Yes, delete the User'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                ])
            ])->checkIfRecordIsSelectableUsing(
                fn (User $record): bool => !$record->isSuperAdmin() && Auth::user()->hasPermissionTo('user.delete'),
            );
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
