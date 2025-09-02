<?php

namespace App\Filament\AdminPPID\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Profile extends Page
{
  protected static ?string $navigationIcon = 'heroicon-o-user';
  protected static string $view            = 'filament.admin-ppid.pages.profile';
  protected static ?string $title          = 'Profil Saya';

  public ?array $data = [];

  public function mount(): void
  {
    $this->form->fill(Auth::user()->only(['name', 'email']));
  }

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('name')
          ->label('Nama')
          ->required(),
        Forms\Components\TextInput::make('email')
          ->label('Email')
          ->email()
          ->required(),
        Forms\Components\TextInput::make('password')
          ->label('Password Baru')
          ->password()
          ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
          ->dehydrated(fn($state) => filled($state))
          ->nullable(),
      ])
      ->statePath('data')
      ->model(Auth::user());
  }

  public function update(): void
  {
    $data = $this->form->getState();

    $user = Auth::user();
    $user->fill($data);
    $user->save();

    Notification::make()
      ->title('Profil berhasil diperbarui')
      ->success()
      ->send();
  }
}
