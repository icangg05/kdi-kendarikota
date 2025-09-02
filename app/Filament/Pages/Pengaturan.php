<?php

namespace App\Filament\Pages;

use App\Models\Pengaturan as ModelsPengaturan;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Pengaturan extends Page
{
  protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
  protected static string $view   = 'filament.pages.pengaturan';
  protected static ?string $title = 'Pengaturan';

  public ?array $data = [];

  public function mount(): void
  {
    // Buat mapping slug => value
    $settings = ModelsPengaturan::all()->pluck('value', 'slug')->toArray();
    $this->form->fill($settings);
  }

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('no_hp_dinas')
          ->label('Nomor HP Dinas'),

        Forms\Components\TextInput::make('ig')
          ->label('Instagram'),

        Forms\Components\TextInput::make('fb')
          ->label('Facebook'),

        Forms\Components\TextInput::make('yt')
          ->label('Youtube'),

        Forms\Components\Textarea::make('alamat')
          ->label('Alamat'),

        Forms\Components\Textarea::make('teks_berjalan')
          ->label('Teks Berjalan')
          ->rows(4)
          ->helperText('Pisahkan dengan simbol "###" untuk memulai kalimat baru.'),
      ])
      ->statePath('data');
  }

  public function update(): void
  {
    $data = $this->form->getState();

    foreach ($data as $slug => $value) {
      ModelsPengaturan::where('slug', $slug)->update(['value' => $value]);
    }

    Notification::make()
      ->title('Pengaturan berhasil diperbarui')
      ->success()
      ->send();
  }
}
