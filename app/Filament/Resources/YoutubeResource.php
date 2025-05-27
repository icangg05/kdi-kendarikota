<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YoutubeResource\Pages;
use App\Filament\Resources\YoutubeResource\RelationManagers;
use App\Models\Youtube;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YoutubeResource extends Resource
{
  protected static ?string $model = Youtube::class;

  protected static ?string $navigationIcon = 'heroicon-o-video-camera';
  protected static ?string $navigationLabel = 'Youtube Video';
  protected static ?string $navigationGroup = 'Data lainnya';

  public static function getSlug(): string
  {
    return 'youtube';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('link')
          ->label('Video ID')
          ->placeholder('Video ID')
          ->helperText('https://www.youtube.com/watch?v=video_id.')
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->query(
        Youtube::query()->orderBy('id', 'desc')
      )
      ->columns([
        TextColumn::make('#')
          ->label('#')
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),

        ViewColumn::make('link')
          ->label('Preview')
          ->view('components.video-frame')
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
      'index' => Pages\ListYoutubes::route('/'),
      // 'create' => Pages\CreateYoutube::route('/create'),
      // 'edit' => Pages\EditYoutube::route('/{record}/edit'),
    ];
  }
}
