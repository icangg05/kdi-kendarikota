<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PejabatResource\Pages;
use App\Filament\Resources\PejabatResource\RelationManagers;
use App\Models\Pejabat;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PejabatResource extends Resource
{
  protected static ?string $model = Pejabat::class;

  protected static ?string $navigationIcon = 'heroicon-o-user-group';
  protected static ?string $navigationLabel = 'Wali Kota & Pejabat Pemerintah';
  protected static ?string $navigationGroup = 'Menu Profil';

  public static function getSlug(): string
  {
    return 'pejabat';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Grid::make(3)->schema([
          Card::make()->schema([
            Grid::make(2)->schema([
              TextInput::make('nama')
                ->placeholder('Nama')
                ->required(),
              Select::make('jabatan_id')
                ->label('Jabatan')
                ->options(\App\Models\Jabatan::orderBy('sort')->pluck('nama', 'id'))
                ->searchable()
                ->required(),
              Select::make('opd_id')
                ->label('OPD')
                ->options(\App\Models\OPD::pluck('nama', 'id'))
                ->searchable(),
              TextInput::make('tahun_periode')
                ->label('Tahun Periode')
                ->placeholder(date('Y'))
                ->maxLength(20),
            ]),
            RichEditor::make('keterangan')
              ->label('Keterangan Lain')
              ->placeholder('Keterangan')
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
              ]),
          ])->columnSpan(2),

          Grid::make(1)->schema([
            Card::make()->schema([
              FileUpload::make('foto')
                ->disk('public')
                ->image()
                ->maxSize(2048)
                ->helperText('Max upload file 2MB.')
                ->directory('foto-pejabat'),
            ]),
            Card::make()->schema([
              TextInput::make('facebook')->label('Link Facebook')->placeholder('https://facebook.com/username'),
              TextInput::make('twitter')->label('Link Twitter')->placeholder('https://twitter.com/username'),
              TextInput::make('instagram')->label('Link Instagram')->placeholder('https://instagram.com/username'),
            ]),
          ])->columnSpan(1),
        ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->query(
        Pejabat::query()
          ->join('jabatan', 'pejabat.jabatan_id', '=', 'jabatan.id')
          ->orderBy('jabatan.sort', 'asc')
          ->select('pejabat.*')
      )
      ->columns([
        TextColumn::make('#')
          ->label('#')
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),

        ImageColumn::make('foto')
          ->label('Foto')
          ->circular()
          ->default(asset('img/default/foto-pejabat.png')),

        TextColumn::make('nama')
          ->label('Nama Lengkap')
          ->searchable(query: fn($query, $search) => $query->orWhere('pejabat.nama', 'like', "%{$search}%")),

        BadgeColumn::make('jabatan.nama')
          ->label('Jabatan')
          ->color('info'),
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
      'index' => Pages\ListPejabats::route('/'),
      'create' => Pages\CreatePejabat::route('/create'),
      'edit' => Pages\EditPejabat::route('/{record}/edit'),
    ];
  }
}
