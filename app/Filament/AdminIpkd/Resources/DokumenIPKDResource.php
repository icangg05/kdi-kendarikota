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
use Illuminate\Support\Carbon;

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

        Forms\Components\TextInput::make('tahun_pelaporan')
          ->label('Tahun Pelaporan')
          ->required()
          ->numeric()
          ->rules(['digits:4'])
          ->placeholder('Masukkan tahun pelaporan')
          ->maxLength(4),

        Forms\Components\DatePicker::make('tgl_publish')
          ->label('Tanggal Publish')
          ->default(now())
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
          ->helperText('Format file: PDF, Gambar, RAR, atau ZIP. Maksimal ukuran file: ' . config('app.max_file_size') / 1024 . 'MB.')
          // ->acceptedFileTypes([
          //   'application/pdf',    // PDF files
          //   'image/*',           // Semua jenis gambar
          //   'application/zip',    // ZIP files
          //   'application/x-rar-compressed', // RAR files
          //   'application/vnd.rar' // RAR files (format alternatif)
          // ])
          ->maxSize(config('app.max_file_size'))
          ->preserveFilenames()
          ->getUploadedFileNameForStorageUsing(function ($file): string {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension    = $file->getClientOriginalExtension();
            $timestamp    = Carbon::now()->format('Ymd_His');
            return $originalName . '_' . $timestamp . '.' . $extension;
          }),
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

        Tables\Columns\TextColumn::make('tahun_pelaporan')
          ->label('Tahun Pelaporan')
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
        Tables\Filters\SelectFilter::make('tahun_pelaporan')
          ->label('Tahun Pelaporan')
          ->options(function () {
            return DokumenIPKD::whereNotNull('tahun_pelaporan')
              ->distinct()
              ->orderByDesc('tahun_pelaporan')
              ->pluck('tahun_pelaporan', 'tahun_pelaporan'); // key = value = tahun
          })
          ->query(function ($query, array $data) {
            if (! $data['value']) {
              return $query;
            }

            return $query->where('tahun_pelaporan', $data['value']);
          }),
      ])

      ->defaultSort('tahun_pelaporan', 'desc')
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
