<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HalamanResource\Pages;
use App\Filament\Resources\HalamanResource\RelationManagers;
use App\Models\Halaman;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HalamanResource extends Resource
{
  protected static ?string $model = Halaman::class;

  protected static ?string $navigationIcon = 'heroicon-o-book-open';
  protected static ?string $navigationLabel = 'Sejarah & Visi Misi';
  protected static ?string $navigationGroup = 'Menu Profil';
  protected static ?int $navigationSort = 10;

  // Show/hide button add
  public static function canCreate(): bool
  {
    return false;
  }
  public static function canDelete(Model $record): bool
  {
    return false;
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['slug'] = \Illuminate\Support\Str::slug($data['judul']);
    return $data;
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Card::make()->schema([
          TextInput::make('judul')
            ->disabled(),
          RichEditor::make('isi')
            ->label('Isi Konten')->toolbarButtons([
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
            ]),
        ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('#')
          ->label('#')
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),

        TextColumn::make('judul')
          ->label('Judul')
          ->searchable()
          ->sortable(),

        TextColumn::make('isi')
          ->label('Isi')
          ->formatStateUsing(fn(?string $state) => str()->words(strip_tags($state), 10))
          ->searchable()
          ->sortable(),

      ])
      ->filters([
        //
      ])
      ->actions([
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
      'index' => Pages\ListHalamen::route('/'),
      'create' => Pages\CreateHalaman::route('/create'),
      'edit' => Pages\EditHalaman::route('/{record}/edit'),
    ];
  }
}
