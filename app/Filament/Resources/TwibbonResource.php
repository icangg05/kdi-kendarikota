<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TwibbonResource\Pages;
use App\Filament\Resources\TwibbonResource\RelationManagers;
use App\Models\Twibbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TwibbonResource extends Resource
{
  protected static ?string $model = Twibbon::class;

  protected static ?string $navigationIcon = 'heroicon-o-sparkles';
  protected static ?string $navigationLabel = 'Twibbon';
  protected static ?string $navigationGroup = 'Data lainnya';

  public static function getSlug(): string
  {
    return 'twibbon';
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
                  ->placeholder('Judul')
                  ->required(),
                Forms\Components\TextInput::make('slogan')
                  ->placeholder('Slogan')
                  ->required(),
                Forms\Components\RichEditor::make('deskripsi')
                  ->placeholder('Deskripsi')
                  ->required()
                  ->toolbarButtons([
                    // 'attachFiles',
                    'blockquote',
                    'bold',
                    'bulletList',
                    'codeBlock',
                    'h2',
                    'h3',
                    'italic',
                    'link',
                    'orderedList',
                    'redo',
                    'strike',
                    'underline',
                    'undo',
                  ])
              ])->columnSpan(2),

            Forms\Components\Grid::make(1)
              ->schema([
                Forms\Components\FileUpload::make('img')
                  ->label('Upload Twibbon')
                  ->required()
                  ->image()
                  ->maxSize(2048)
                  ->helperText('Max upload file 2MB.')
                  ->disk('public')
                  ->directory('twibbon/' . date('Y')),
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
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),

        TextColumn::make('title')
          ->label('judul')
          ->sortable()
          ->searchable(),

        TextColumn::make('deskripsi')
          ->label('Deskripsi')
          ->width('450px')
          ->wrap()
          ->formatStateUsing(fn(?string $state) => strip_tags($state))
          ->searchable()
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
      'index' => Pages\ListTwibbons::route('/'),
      // 'create' => Pages\CreateTwibbon::route('/create'),
      // 'edit' => Pages\EditTwibbon::route('/{record}/edit'),
    ];
  }
}
