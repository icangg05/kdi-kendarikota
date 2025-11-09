<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AplikasiResource\Pages;
use App\Filament\Resources\AplikasiResource\RelationManagers;
use App\Models\Aplikasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AplikasiResource extends Resource
{
  protected static ?string $model = Aplikasi::class;

  protected static ?string $navigationIcon = 'heroicon-o-cube';
  protected static ?string $navigationLabel = 'Aplikasi Kendarikota';
  protected static ?string $navigationGroup = 'Data lainnya';

  public static function getSlug(): string
  {
    return 'aplikasi';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Grid::make(3)
          ->schema([
            Forms\Components\Grid::make(1)
              ->schema([
                Forms\Components\TextInput::make('nama')
                  ->placeholder('Nama Aplikasi')
                  ->required(),
                Forms\Components\TextInput::make('link')
                  ->placeholder('Link Aplikasi')
                  ->label('Link Aplikasi')
                  ->required(),
              ])->columnSpan(2),

            Forms\Components\Grid::make(1)
              ->schema([
                Forms\Components\FileUpload::make('icon')
                  ->image()
                  ->maxSize(1024)
                  ->helperText('Max upload file 1MB.')
                  ->disk('public')
                  ->directory('icon-aplikasi'),
              ])->columnSpan(1)
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

        ImageColumn::make('icon')
          ->label('Logo')
          ->circular()
          ->default(asset('img/default/icon-aplikasi.png')),

        TextColumn::make('nama')
          ->label('Nama Aplikasi')
          ->searchable()
          ->sortable(),

        TextColumn::make('link')
          ->label('Link')
          ->searchable()
          ->sortable(),

        BadgeColumn::make('link_url')
          ->label('URL Aplikasi')
          ->color('success')
          ->formatStateUsing(fn(string $state): string => 'Kunjungi')
          ->url(fn(string $state): string => $state, true)
          ->getStateUsing(fn($record) => $record->link)
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
      'index' => Pages\ListAplikasis::route('/'),
      // 'create' => Pages\CreateAplikasi::route('/create'),
      // 'edit' => Pages\EditAplikasi::route('/{record}/edit'),
    ];
  }
}
