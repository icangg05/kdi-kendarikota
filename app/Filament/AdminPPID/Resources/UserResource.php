<?php

namespace App\Filament\AdminPPID\Resources;

use App\Filament\AdminPPID\Resources\UserResource\Pages;
use App\Filament\AdminPPID\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
  protected static ?string $model = User::class;

  protected static ?string $navigationIcon = 'heroicon-o-users';

  public static function getNavigationGroup(): ?string
  {
    return 'OPD';
  }

  public static function getNavigationLabel(): string
  {
    return 'Data OPD';
  }

  public static function getPluralLabel(): string
  {
    return 'Data OPD';
  }

  public static function getModelLabel(): string
  {
    return 'Data OPD';
  }

  public static function getSlug(): string
  {
    return 'opd';
  }

  public static function canAccess(): bool
  {
    return Auth::user()->role == 'admin-ppid';
  }

  public static function getEloquentQuery(): Builder
  {
    $query = parent::getEloquentQuery();
    $query->where('role', 'admin-opd');

    return $query;
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([

        Forms\Components\Card::make()
          ->schema([
            Forms\Components\TextInput::make('name')
              ->label('Nama OPD')
              ->placeholder('Nama OPD')
              ->required()
              ->maxLength(255),

            Forms\Components\TextInput::make('email')
              ->label('Email')
              ->placeholder('Email')
              ->email()
              ->unique(ignoreRecord: true)
              ->required()
              ->maxLength(255),

            Forms\Components\Hidden::make('role')->default('admin-opd'),
          ])
          ->columns(2)
          ->columnSpanFull(),

        Forms\Components\Card::make()
          ->schema([
            Forms\Components\TextInput::make('password')
              ->label('Password')
              ->placeholder('******')
              ->password()
              ->dehydrateStateUsing(fn($state) => ! empty($state) ? bcrypt($state) : null)
              ->dehydrated(fn($state) => filled($state))
              ->required(fn(string $context) => $context === 'create')
              ->maxLength(255),
          ])
          ->columns(2)
          ->columnSpanFull(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('#')
          ->label('#')
          ->rowIndex()
          ->width('7%'),

        Tables\Columns\TextColumn::make('name')
          ->label('Nama OPD')
          ->searchable()
          ->sortable(),

        Tables\Columns\TextColumn::make('email')
          ->label('Email')
          ->searchable()
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
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
