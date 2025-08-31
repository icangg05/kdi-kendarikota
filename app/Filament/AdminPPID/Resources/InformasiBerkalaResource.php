<?php

namespace App\Filament\AdminPPID\Resources;

use App\Filament\AdminPPID\Resources\InformasiBerkalaResource\Pages;
use App\Filament\AdminPPID\Resources\InformasiBerkalaResource\RelationManagers;
use App\Models\DokumenPPID;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class InformasiBerkalaResource extends Resource
{
  protected static ?string $model = DokumenPPID::class;

  protected static ?string $navigationIcon = 'heroicon-o-clock';

  public static function getNavigationGroup(): ?string
  {
    return 'Informasi Publik';
  }

  public static function getNavigationLabel(): string
  {
    return 'Berkala';
  }

  public static function getPluralLabel(): string
  {
    return 'Informasi Berkala';
  }

  public static function getModelLabel(): string
  {
    return 'Informasi Berkala';
  }

  public static function getSlug(): string
  {
    return 'informasi-berkala';
  }

  public static function getEloquentQuery(): Builder
  {
    $query = parent::getEloquentQuery();
    $query->with('user')->where('kategori', 'informasi-berkala');

    $role = Auth::user()->role;

    if ($role === 'admin-opd') {
      $query->where('users_id', Auth::user()->id);
    }

    return $query;
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Card::make()->schema([
          Grid::make(2)->schema([
            Forms\Components\Hidden::make('kategori')
              ->default('informasi-berkala'),
            Forms\Components\Hidden::make('slug'),
            Forms\Components\TextInput::make('judul')
              ->label('Nama Dokumen')
              ->placeholder('Nama Dokumen')
              ->unique(
                table: DokumenPPID::class,
                column: 'judul',
                ignoreRecord: true,
              )->required(),

            Forms\Components\DatePicker::make('tanggal_publish')
              ->default(now())
              ->required(),

            Forms\Components\Select::make('users_id')
              ->label('OPD')
              ->options(User::where('role', 'admin-opd')->pluck('name', 'id'))
              ->default(fn() => Auth::user()->role === 'admin-opd' ? Auth::id() : null)
              ->disabled(fn() => Auth::user()->role === 'admin-opd')
              ->dehydrated() // supaya tetap disimpan meskipun disabled
              ->searchable(),
            // ->required(),

            Forms\Components\FileUpload::make('lampiran')
              ->label('Upload Dokumen')
              ->directory('dokumen-ppid')
              ->disk('public')
              ->acceptedFileTypes([
                'application/pdf',
                'application/x-pdf',
                'application/octet-stream',
              ])
              ->maxSize(config('app.max_file_size'))
              ->helperText('Maksimum ' . config('app.max_file_size') / 1024 . 'MB. Hanya file PDF yang diperbolehkan.')
              ->nullable()
              ->preserveFilenames()
              ->getUploadedFileNameForStorageUsing(function ($file): string {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension    = $file->getClientOriginalExtension();
                $timestamp    = Carbon::now()->format('Ymd_His');
                return $originalName . '_' . $timestamp . '.' . $extension;
              }),

            Forms\Components\TextInput::make('total_unduh')
              ->numeric()
              ->default(0),
            Forms\Components\TextInput::make('total_lihat')
              ->numeric()
              ->default(0),
          ])
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
          ->label('Nama Dokumen')
          ->wrap()
          ->searchable(),

        TextColumn::make('user.name')
          ->label('OPD')
          ->wrap()
          ->searchable()
          ->sortable()
          ->hidden(Auth::user()->role === 'admin-opd'),

        TextColumn::make('tanggal_publish')
          ->label('Tanggal Publish')
          ->sortable()
          ->dateTime('d M Y'),

        TextColumn::make('lampiran')
          ->label('Dokumen')
          ->url(fn($record) => asset("storage/$record->lampiran"))
          ->openUrlInNewTab()
          ->badge()
          ->color('info')
          ->formatStateUsing(fn($state) => 'Lihat Dokumen')
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
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListInformasiBerkalas::route('/'),
      'create' => Pages\CreateInformasiBerkala::route('/create'),
      'edit' => Pages\EditInformasiBerkala::route('/{record}/edit'),
    ];
  }
}
