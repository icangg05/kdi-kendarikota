<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerdaResource\Pages;
use App\Filament\Resources\PerdaResource\RelationManagers;
use App\Models\Perda;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class PerdaResource extends Resource
{
  protected static ?string $model = Perda::class;

  protected static ?string $navigationIcon = 'heroicon-o-document-text';
  protected static ?string $navigationLabel = 'Peraturan Daerah';
  protected static ?string $navigationGroup = 'Menu Peraturan Daerah';
  protected static ?int $navigationSort = 50;

  public static function getSlug(): string
  {
    return 'peraturan-daerah';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('no_perda')
          ->placeholder('Nomor Perda')
          ->required(),
        Forms\Components\TextInput::make('tentang')
          ->placeholder('Tentang')
          ->required(),
        Forms\Components\DateTimePicker::make('tanggal')
          ->placeholder('Tanggal upload')
          ->required(),
        Forms\Components\TextInput::make('link')
          ->placeholder('Link')
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
          ->rowIndex()
          ->width('7%'),

        TextColumn::make('no_perda')
          ->searchable()
          ->sortable(),

        TextColumn::make('tentang')
          ->width('400px')
          ->searchable()
          ->wrap()
          ->sortable(),

        BadgeColumn::make('link')
          ->label('Link')
          ->color('info')
          ->formatStateUsing(fn(?string $state) => 'Link')
          ->url(fn(?string $state): ?string => $state, true),

        TextColumn::make('tanggal')
          ->label('Tanggal upload')
          ->sortable()
          ->formatStateUsing(fn($state) => Carbon::parse($state)->format('d m Y - H:i:s')),
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
      'index' => Pages\ListPerdas::route('/'),
      // 'create' => Pages\CreatePerda::route('/create'),
      // 'edit' => Pages\EditPerda::route('/{record}/edit'),
    ];
  }
}
