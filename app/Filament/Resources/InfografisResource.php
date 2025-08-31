<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfografisResource\Pages;
use App\Filament\Resources\InfografisResource\RelationManagers;
use App\Models\Infografis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InfografisResource extends Resource
{
  protected static ?string $model = Infografis::class;

  protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
  protected static ?string $navigationLabel = 'Infografis';
  protected static ?string $navigationGroup = 'Data lainnya';

  public static function getSlug(): string
  {
    return 'infografis';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Grid::make(3)
          ->schema([
            Forms\Components\Grid::make(1)
              ->schema([
                Forms\Components\TextInput::make('title')
                  ->label('Judul')
                  ->required(),
                Forms\Components\DateTimePicker::make('release')
                  ->default(now())
                  ->label('Tanggal')
                  ->required(),
              ])->columnSpan(2),

            Forms\Components\Grid::make(1)
              ->schema([
                Forms\Components\FileUpload::make('img')
                  ->label('Gambar')
                  ->helperText('Max upload file 2MB.')
                  ->required()
                  ->image()
                  ->maxSize(2048)
                  ->disk('public')
                  ->directory('infografis/' . date('Y')),
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
          ->placeholder('Judul')
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),

        TextColumn::make('title')
          ->label('judul')
          ->sortable()
          ->searchable(),

        TextColumn::make('release')
          ->label('Release')
          ->dateTime('d F Y')
          ->sortable(),


        ImageColumn::make('img')
          ->label('Gambar')
          ->width('150px')
          ->height('auto'),
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
      'index' => Pages\ListInfografis::route('/'),
      // 'create' => Pages\CreateInfografis::route('/create'),
      // 'edit' => Pages\EditInfografis::route('/{record}/edit'),
    ];
  }
}
