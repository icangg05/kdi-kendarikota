<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgendaResource\Pages;
use App\Filament\Resources\AgendaResource\RelationManagers;
use App\Models\Agenda;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgendaResource extends Resource
{
  protected static ?string $model = Agenda::class;

  protected static ?string $navigationIcon = 'heroicon-o-calendar';
  protected static ?string $navigationGroup = 'Menu Event';
  protected static ?int $navigationSort = 30;

  public static function getSlug(): string
  {
    return 'agenda';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('nama')
          ->placeholder('Nama')
          ->required(),
        Forms\Components\DatePicker::make('tanggal')
          ->default(now())
          ->required(),
        Forms\Components\Textarea::make('deskripsi')->placeholder('Deskripsi')
          ->rows(4)
          ->required(),
        Forms\Components\TextInput::make('lokasi')
          ->placeholder('Lokasi')
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

        TextColumn::make('nama')
          ->width('250px')
          ->wrap()
          ->searchable()
          ->sortable(),

        TextColumn::make('deskripsi')
          ->width('250px')
          ->wrap()
          ->searchable()
          ->sortable(),

        TextColumn::make('tanggal')
          ->label('Tanggal')
          ->searchable()
          ->sortable(),

        TextColumn::make('lokasi')
          ->searchable()
          ->sortable(),
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
      'index' => Pages\ListAgendas::route('/'),
      // 'create' => Pages\CreateAgenda::route('/create'),
      // 'edit' => Pages\EditAgenda::route('/{record}/edit'),
    ];
  }
}
