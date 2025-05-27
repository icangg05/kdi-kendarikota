<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengumumanResource\Pages;
use App\Filament\Resources\PengumumanResource\RelationManagers;
use App\Models\Pengumuman;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengumumanResource extends Resource
{
  protected static ?string $model = Pengumuman::class;

  protected static ?string $navigationIcon = 'heroicon-o-megaphone';
  protected static ?string $navigationGroup = 'Menu Event';

  public static function getSlug(): string
  {
    return 'pengumuman';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('judul')
          ->placeholder('Judul')
          ->required(),
        Forms\Components\TextInput::make('link')
          ->placeholder('Link File')
          ->required(),
        Forms\Components\TextInput::make('sumber')
          ->placeholder('Sumber')
          ->required(),
        Forms\Components\DateTimePicker::make('tanggal')
          ->default(now())
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->defaultSort('id', 'desc')
      ->columns([
        TextColumn::make('#')
          ->label('#')
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),

        TextColumn::make('judul')
          ->searchable()
          ->sortable()
          ->width('400px')
          ->wrap(),
        // ->formatStateUsing(fn(?string $state): string => str()->words($state, 7)),

        TextColumn::make('sumber')
          ->searchable()
          ->sortable(),

        BadgeColumn::make('link')
          ->label('Link File')
          ->color('info')
          ->formatStateUsing(fn(?string $state) => 'Lihat')
          ->url(fn(?string $state): ?string => $state, true),

        TextColumn::make('tanggal')
          ->label('Tanggal')
          ->sortable()
          ->formatStateUsing(fn($state) =>  Carbon::parse($state)->format('d M Y - H:i:s'))
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\DeleteAction::make(),
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
      'index' => Pages\ListPengumumen::route('/'),
      // 'create' => Pages\CreatePengumuman::route('/create'),
      // 'edit' => Pages\EditPengumuman::route('/{record}/edit'),
    ];
  }
}
