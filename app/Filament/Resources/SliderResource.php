<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SliderResource extends Resource
{
  protected static ?string $model = Slider::class;

  protected static ?string $navigationIcon = 'heroicon-o-photo';
  protected static ?string $navigationLabel = 'Slider Beranda';
  protected static ?string $navigationGroup = 'Data lainnya';

  public static function getSlug(): string
  {
    return 'slider';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\FileUpload::make('image')
          ->label('Upload Gambar')
          ->image()
          ->maxSize(2048)
          ->disk('public')
          ->directory('slider')
          ->required(),
        Forms\Components\Select::make('jenis_gambar')
          ->options([
            'banner' => 'Banner',
            'hero halaman' => 'Hero Halaman',
            'slider' => 'Slider',
          ])
          ->default('slider')
          ->disabled()
          ->label('Tampilkan Sebagai')
          ->required()
          ->helperText('Max upload file 2MB.')
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->query(
        Slider::query()->orderBy('jenis_gambar')
      )
      ->columns([
        Tables\Columns\TextColumn::make('#')
          ->label('#')
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),
        Tables\Columns\ImageColumn::make('image')
          ->label('Gambar')
          ->width('300px')
          ->height('auto'),
        BadgeColumn::make('jenis_gambar')
          ->label('Tampilkan Sebagai')
          ->color(
            fn(string $state): string =>
            $state == 'banner' ? 'success' : ($state == 'slider' ? 'info' : 'warning')
          )
          ->formatStateUsing(
            fn(string $state): string =>
            $state == 'banner' ? 'BANNER' : ($state == 'slider' ? 'SLIDER' : 'HERO HALAMAN')
          )
          ->url(fn(string $state): string => '#')
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\DeleteAction::make()
          ->hidden(
            fn($record): bool => in_array($record->jenis_gambar, ['banner', 'hero halaman'])
          ),
        Tables\Actions\EditAction::make(),
      ])
      ->bulkActions([
        // Tables\Actions\BulkActionGroup::make([
        //   Tables\Actions\DeleteBulkAction::make(),
        // ]),
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
      'index' => Pages\ListSliders::route('/'),
      // 'create' => Pages\CreateSlider::route('/create'),
      // 'edit' => Pages\EditSlider::route('/{record}/edit'),
    ];
  }
}
