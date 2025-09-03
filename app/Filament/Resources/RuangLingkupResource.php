<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RuangLingkupResource\Pages;
use App\Filament\Resources\RuangLingkupResource\RelationManagers;
use App\Models\RuangLingkup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class RuangLingkupResource extends Resource
{
  protected static ?string $model = RuangLingkup::class;

  protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
  protected static ?string $navigationGroup = 'Menu Profil';


  public static function canDelete(Model $record): bool
  {
    return false;
  }

  public static function getNavigationUrl(): string
  {
    $first = RuangLingkup::query()->first();

    return $first
      ? static::getUrl('edit', ['record' => $first])
      : static::getUrl('create');
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        \Filament\Forms\Components\Card::make()->schema([

          \Filament\Forms\Components\Grid::make(3)->schema([

            \Filament\Forms\Components\Grid::make(1)->schema([
              Forms\Components\TextInput::make('judul')
                ->label('Judul')
                ->required(),
              Forms\Components\DatePicker::make('tanggal_publish')
                ->label('Tanggal Publish')
                ->required(),
              Forms\Components\Hidden::make('slug'),
              Forms\Components\RichEditor::make('konten')
                ->label('Isi Konten')
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('richeditor')
                ->disableGrammarly()
                ->required(),

            ])->columnSpan(2),

            \Filament\Forms\Components\Grid::make(1)->schema([

              Forms\Components\FileUpload::make('sampul')
                ->label('Upload Sampul')
                ->image()
                ->maxSize(config('app.max_img_size'))
                ->helperText('Maksimum ' . config('app.max_img_size') / 1024 . 'MB. Format file: jpg, png, jpeg.')
                ->directory('gambar')
                ->required(false),

              // Forms\Components\FileUpload::make('lampiran')
              //   ->label('Upload Dokumen')
              //   ->directory('dokumen')
              //   ->disk('public')
              //   ->acceptedFileTypes([
              //     'application/pdf',
              //     'application/x-pdf',
              //     'application/octet-stream',
              //   ])
              //   ->maxSize(config('app.max_file_size'))
              //   ->helperText('Maksimum ' . config('app.max_file_size') / 1024 . 'MB. Hanya file PDF yang diperbolehkan.')
              //   ->nullable()
              //   ->preserveFilenames()
              //   ->getUploadedFileNameForStorageUsing(function ($file): string {
              //     $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
              //     $extension    = $file->getClientOriginalExtension();
              //     $timestamp    = Carbon::now()->format('Ymd_His');
              //     return $originalName . '_' . $timestamp . '.' . $extension;
              //   }),
            ])->columnSpan(1),
          ])
        ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        //
      ])
      ->filters([
        //
      ])
      ->actions([
        // Tables\Actions\EditAction::make(),
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
      'index' => Pages\ListRuangLingkups::route('/'),
      'create' => Pages\CreateRuangLingkup::route('/create'),
      'edit' => Pages\EditRuangLingkup::route('/{record}/edit'),
    ];
  }
}
