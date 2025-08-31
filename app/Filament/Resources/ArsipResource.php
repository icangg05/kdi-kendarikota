<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArsipResource\Pages;
use App\Filament\Resources\ArsipResource\RelationManagers;
use App\Models\Arsip;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

use function PHPUnit\Framework\isNull;

class ArsipResource extends Resource
{
  protected static ?string $model = Arsip::class;

  protected static ?string $navigationIcon = 'heroicon-o-archive-box';
  protected static ?string $navigationLabel = 'Arsip';
  protected static ?string $navigationGroup = 'Menu Arsip';
  protected static ?int $navigationSort = 40;

  public static function getSlug(): string
  {
    return 'arsip';
  }


  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('judul')->placeholder('Judul Arsip')
          ->required(),
        Forms\Components\TextInput::make('sumber')->placeholder('Sumber Arsip')
          ->required(),
        Forms\Components\DateTimePicker::make('release')->placeholder('Tanggal Rilis')
          ->required(),
        Forms\Components\DateTimePicker::make('penetapan')
          ->placeholder('Tanggal Penetapan'),
        Forms\Components\FileUpload::make('link')
          ->label('Upload File')
          ->placeholder('Max upload file: 100MB. Type: .pdf, .zip, .rar')
          ->disk('public')
          ->acceptedFileTypes(['application/pdf', 'application/zip', 'application/x-rar-compressed'])
          ->directory('dokumen/' . date('Y'))
          ->maxSize(102400)
          ->required()
          ->rules([
            'file',
            'mimes:pdf,zip,rar',
            'max:102400',
          ])
          ->validationMessages([
            'mimes' => 'File harus berupa PDF, ZIP, atau RAR.',
            'max' => 'Ukuran file tidak boleh melebihi 100MB.',
          ])
          ->getUploadedFileNameForStorageUsing(
            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
              ->prepend(rand(0, 9) . str()->random(1) . rand(0, 9) . str()->random(1) . '-'),
          )
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

        TextColumn::make('sumber')
          ->searchable()
          ->sortable(),

        BadgeColumn::make('link')
          ->label('File')
          ->color('info')
          ->formatStateUsing(fn(?string $state) => 'Lihat')
          ->url(function (?string $state): ?string {
            if (empty($state)) {
              return null;
            }
            if (str_starts_with($state, 'dokumen/')) {
              return Storage::url($state);
            }
            return $state;
          }, true),

        TextColumn::make('release')
          ->sortable()
          ->formatStateUsing(fn($state) =>  Carbon::parse($state)->format('j M Y - H:i:s'))
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
      'index' => Pages\ListArsips::route('/'),
      // 'create' => Pages\CreateArsip::route('/create'),
      // 'edit' => Pages\EditArsip::route('/{record}/edit'),
    ];
  }
}
