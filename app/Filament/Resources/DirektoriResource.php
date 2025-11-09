<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DirektoriResource\Pages;
use App\Filament\Resources\DirektoriResource\RelationManagers;
use App\Filament\Resources\DirektoriResource\RelationManagers\LokasiRelationManager;
use App\Models\Direktori;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DirektoriResource extends Resource
{
  protected static ?string $model = Direktori::class;

  protected static ?string $navigationIcon = 'heroicon-o-folder';
  protected static ?string $navigationLabel = 'Direktori';
  protected static ?string $navigationGroup = 'Menu Direktori';
  protected static ?int $navigationSort = 20;

  public static function getSlug(): string
  {
    return 'direktori';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Card::make()
          ->schema([
            Forms\Components\Grid::make(2)
              ->schema([
                Forms\Components\TextInput::make('nama')
                  ->required(),
                Forms\Components\TextInput::make('deskripsi'),
              ])
          ])
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

        TextColumn::make('nama')
          ->searchable()
          ->placeholder('Nama')
          ->sortable(),

        TextColumn::make('deskripsi')
          ->searchable()
          ->placeholder('Deskripsi')
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
      LokasiRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListDirektoris::route('/'),
      'create' => Pages\CreateDirektori::route('/create'),
      'edit' => Pages\EditDirektori::route('/{record}/edit'),
    ];
  }
}
