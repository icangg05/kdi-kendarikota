<?php

namespace App\Filament\AdminIpkd\Resources;

use App\Filament\AdminIpkd\Resources\DokumenIPKDResource\Pages;
use App\Models\DokumenIPKD;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class DokumenIPKDResource extends Resource
{
  protected static ?string $model = DokumenIPKD::class;

  protected static ?string $navigationIcon = 'heroicon-o-document-text';
  protected static ?string $navigationLabel = 'Dokumen IPKD';
  protected static ?string $modelLabel = 'Dokumen IPKD';
  protected static ?string $navigationGroup = 'IPKD';

  public static function getSlug(): string
  {
    return 'dokumen-ipkd';
  }


  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('judul')
          ->required()
          ->label('Judul Dokumen')
          ->placeholder('Masukkan judul dokumen IPKD')
          ->maxLength(255),

        Forms\Components\DatePicker::make('tgl_publish')
          ->label('Tanggal Publish')
          ->required()
          ->placeholder('Masukkan tanggal publish')
          ->native(false),

        Forms\Components\DatePicker::make('tgl_disahkan')
          ->label('Tanggal Disahkan')
          ->placeholder('Masukkan tanggal disahkan')
          ->native(false),

        Forms\Components\FileUpload::make('lampiran')
          ->label('Lampiran Dokumen')
          ->directory('dokumen-ipkd')
          ->downloadable()
          ->openable()
          ->previewable(false)
          ->helperText('Format file: PDF atau Gambar. Maksimal ukuran file: ' . config('app.max_file_size') / 1024 . 'MB.')
          ->acceptedFileTypes([
            'application/pdf',
            'image/*',
          ]),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('no')
          ->label('No')
          ->rowIndex()
          ->alignCenter(),

        Tables\Columns\TextColumn::make('judul')
          ->label('Judul Dokumen IPKD')
          ->searchable()
          ->wrap(),

        Tables\Columns\TextColumn::make('tgl_publish')
          ->label('Dipublish')
          ->date('d M Y')
          ->searchable(),

        Tables\Columns\TextColumn::make('tgl_disahkan')
          ->label('Disahkan')
          ->searchable()
          ->date('d M Y'),
      ])
      ->filters([
        Tables\Filters\SelectFilter::make('tahun')
          ->label('Tahun')
          ->options(function () {
            return DokumenIPKD::selectRaw('YEAR(tgl_publish) as tahun')
              ->whereNotNull('tgl_publish')
              ->distinct()
              ->orderByDesc('tahun')
              ->pluck('tahun', 'tahun'); // key = value = tahun
          })
          ->query(function ($query, array $data) {
            if (! $data['value']) {
              return $query;
            }

            return $query->whereYear('tgl_publish', $data['value']);
          }),
      ])

      ->defaultSort('tgl_publish', 'desc')
      ->actions([
        // ✅ Tombol DOWNLOAD
        Action::make('download')
          ->color('success')
          ->label('Download')
          ->icon('heroicon-o-arrow-down-tray')
          ->visible(fn($record) => $record->lampiran)
          ->url(fn($record) => route('download-ipkd', ['id' => $record->id])),

        // ✅ Edit modal
        Tables\Actions\EditAction::make()
          ->modalHeading('Edit Dokumen IPKD')
          ->modalWidth('5xl')
          ->modalSubmitActionLabel('Simpan Perubahan'),

        Tables\Actions\DeleteAction::make()
          ->label('Hapus')
          ->modalHeading('Hapus Dokumen IPKD')
          ->modalDescription('Yakin ingin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan.')
          ->modalSubmitActionLabel('Ya, Hapus')
          ->icon('heroicon-o-trash')
          ->color('danger'),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListDokumenIPKDS::route('/'),
      // 'create' => Pages\CreateDokumenIPKD::route('/create'),
      // 'edit' => Pages\EditDokumenIPKD::route('/{record}/edit'),
    ];
  }
}
