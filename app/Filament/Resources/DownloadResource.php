<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DownloadResource\Pages;
use App\Filament\Resources\DownloadResource\RelationManagers;
use App\Models\Download;
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

class DownloadResource extends Resource
{
  protected static ?string $model = Download::class;

  protected static ?string $navigationIcon = 'heroicon-o-chart-pie';
  protected static ?string $navigationLabel = 'Statistik';
  protected static ?string $navigationGroup = 'Menu Statistik';
  protected static ?int $navigationSort = 60;

  public static function getSlug(): string
  {
    return 'download';
  }


  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('judul')->placeholder('Judul')
          ->required(),
        Forms\Components\TextInput::make('deskripsi')
          ->placeholder('Deskripsi')
          ->required(),
        Forms\Components\DateTimePicker::make('tanggal')
          ->required(),
        Forms\Components\TextInput::make('link')
          ->placeholder('Link')
          ->url()
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

        TextColumn::make('deskripsi')
          ->searchable()
          ->sortable(),

        BadgeColumn::make('file')
          ->label('Data File')
          ->color('info')
          ->formatStateUsing(fn(?string $state) => 'Data File')
          ->url(fn(?string $state): ?string => $state, true),

        TextColumn::make('tanggal')
          ->sortable()
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
      'index' => Pages\ListDownloads::route('/'),
      // 'create' => Pages\CreateDownload::route('/create'),
      // 'edit' => Pages\EditDownload::route('/{record}/edit'),
    ];
  }
}
