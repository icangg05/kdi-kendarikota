<?php

namespace App\Filament\AdminPPID\Resources;

use App\Filament\AdminPPID\Resources\PermohonanInformasiResource\Pages;
use App\Filament\AdminPPID\Resources\PermohonanInformasiResource\RelationManagers;
use App\Models\PermohonanInformasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Support\Carbon;

class PermohonanInformasiResource extends Resource
{
  protected static ?string $model = PermohonanInformasi::class;

  protected static ?string $navigationIcon = 'heroicon-o-document-text';

  public static function getNavigationGroup(): ?string
  {
    return 'Pengajuan & Keberatan Informasi Publik';
  }

  public static function getNavigationLabel(): string
  {
    return 'Permohonan Informasi';
  }

  public static function getPluralLabel(): string
  {
    return 'Permohonan Informasi';
  }

  public static function getModelLabel(): string
  {
    return 'Permohonan Informasi';
  }

  public static function getSlug(): string
  {
    return 'permohonan-informasi';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([

        Forms\Components\Section::make('🧑 Identitas Pemohon')
          ->schema([
            Forms\Components\TextInput::make('nama_pemohon')
              ->label('Nama Pemohon')
              ->required()
              ->maxLength(255),

            Forms\Components\TextInput::make('nomor_ktp')
              ->label('Nomor KTP')
              ->required()
              ->maxLength(255),

            Forms\Components\FileUpload::make('foto_ktp')
              ->label('Foto KTP')
              ->image()
              ->disk('public')
              ->directory('foto-ktp')
              ->required(),

            Forms\Components\TextInput::make('nomor_pengesahan')
              ->label('Nomor Pengesahan (Badan Hukum)')
              ->maxLength(255)
              ->nullable(),

            Forms\Components\Textarea::make('alamat')
              ->label('Alamat')
              ->required()
              ->columnSpanFull(),

            Forms\Components\TextInput::make('pekerjaan')
              ->label('Pekerjaan')
              ->required()
              ->maxLength(255),
          ])
          ->columns(2),

        Forms\Components\Section::make('📞 Kontak')
          ->schema([
            Forms\Components\TextInput::make('no_hp')
              ->label('Nomor HP')
              ->tel()
              ->required(),

            Forms\Components\TextInput::make('email')
              ->label('Email')
              ->email()
              ->required(),
          ])
          ->columns(2),

        Forms\Components\Section::make('📄 Permohonan Informasi')
          ->schema([
            Forms\Components\Textarea::make('rincian_informasi')
              ->label('Rincian Informasi yang Dibutuhkan')
              ->required()
              ->columnSpanFull(),

            Forms\Components\Textarea::make('tujuan_permohonan')
              ->label('Tujuan Permohonan Informasi')
              ->required()
              ->columnSpanFull(),

            Forms\Components\Select::make('cara_memperoleh_informasi')
              ->label('Cara Memperoleh Informasi')
              ->options([
                'Melihat' => 'Melihat',
                'Membaca' => 'Membaca',
                'Mendengarkan' => 'Mendengarkan',
                'Mencatat' => 'Mencatat',
              ])
              ->required(),

            Forms\Components\Select::make('mendapatkan_salinan')
              ->label('Mendapatkan Salinan Informasi')
              ->options([
                'Hardcopy' => 'Hardcopy',
                'Softcopy' => 'Softcopy',
              ])
              ->required(),

            Forms\Components\Select::make('cara_mendapatkan_salinan')
              ->label('Cara Mendapatkan Salinan')
              ->options([
                'Mengambil Langsung' => 'Mengambil Langsung',
                'Kurir'              => 'Kurir',
                'POS'                => 'POS',
                'Fax'                => 'Fax',
                'Email'              => 'Email',
                'WhatsApp'           => 'WhatsApp',
              ])
              ->required(),

            Forms\Components\DatePicker::make('tanggal_diajukan')
              ->label('Tanggal Diajukan')
              ->required(),
          ])
          ->columns(2),
      ]);
  }

  public static function canCreate(): bool
  {
    return false;
  }

  public static function canAccess(): bool
  {
    return Auth::user()->role == 'admin-ppid';
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('#')
          ->label('#')
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),

        Tables\Columns\TextColumn::make('nomor_registrasi')
          ->label('No Registrasi')
          ->searchable()
          ->sortable(),

        Tables\Columns\TextColumn::make('nama_pemohon')
          ->label('Nama Pemohon')
          ->searchable()
          ->sortable(),

        // Tables\Columns\TextColumn::make('nomor_ktp')
        //   ->label('KTP')
        //   ->formatStateUsing(fn($state) => substr($state, 0, 4) . '****'), // masking

        // Tables\Columns\TextColumn::make('no_hp')
        //   ->label('No HP'),

        // Tables\Columns\TextColumn::make('email'),

        Tables\Columns\TextColumn::make('rincian_informasi')
          ->label('Rincian')
          ->limit(40), // tampil sebagian

        Tables\Columns\TextColumn::make('tanggal_diajukan')
          ->label('Diajukan')
          ->dateTime('d M Y'),

        // Kolom Status
        Tables\Columns\TextColumn::make('status')
          ->label('Status')
          ->formatStateUsing(function ($state) {
            return match ($state) {
              'Pending'   => 'Pending',
              'Ditolak'   => 'Ditolak',
              'Disetujui' => 'Disetujui',
            };
          })
          ->badge()
          ->color(fn($state) => match ($state) {
            'Pending'   => 'warning',   // kuning
            'Ditolak'   => 'danger',    // merah
            'Disetujui' => 'success',   // hijau
          })
          ->searchable(),
      ])
      ->filters([
        //
      ])
      ->actions([
        // Tables\Actions\EditAction::make(),
        Tables\Actions\Action::make('konfirmasi')
          ->label('Konfirmasi')
          ->icon('heroicon-o-check-circle')
          ->color('primary')
          ->form([
            Forms\Components\Select::make('status')
              ->label('Status Konfirmasi')
              ->options([
                'Pending'   => 'Pending',
                'Disetujui' => 'Disetujui',
                'Ditolak'   => 'Ditolak',
              ])
              ->required(),

            Forms\Components\Textarea::make('catatan')
              ->label('Catatan')
              ->placeholder('Tambahkan catatan...')
              ->rows(4),

            Forms\Components\FileUpload::make('lampiran')
              ->label('Lampiran')
              ->directory('dokumen-ppid')
              ->disk('public')
              ->acceptedFileTypes(['application/pdf'])
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
          ])
          ->fillForm(function ($record) {
            return [
              'status'   => $record->status,
              'catatan'  => $record->catatan,
              'lampiran' => $record->lampiran,
            ];
          })
          ->action(function ($record, array $data) {
            $record->update([
              'status'   => $data['status'],
              'catatan'  => $data['catatan'] ?? null,
              'lampiran' => $data['lampiran'] ?? null,
            ]);
          })
          ->modalHeading('Konfirmasi Permohonan')
          ->modalButton('Simpan'),

        Tables\Actions\ViewAction::make()
          ->label('Detail')
          ->infolist([
            Section::make('🧑 Identitas Pemohon')
              ->collapsible()
              ->schema([
                TextEntry::make('nama_pemohon')->label('Nama Pemohon'),
                TextEntry::make('nomor_ktp')->label('Nomor KTP'),
                TextEntry::make('nomor_pengesahan')->label('Nomor Pengesahan')->placeholder('-'),
                TextEntry::make('pekerjaan')->label('Pekerjaan'),
                TextEntry::make('alamat')->label('Alamat')->columnSpanFull(),
              ]),

            Section::make('📞 Kontak')
              ->collapsible()
              ->schema([
                TextEntry::make('no_hp')->label('Nomor HP'),
                TextEntry::make('email')->label('Email'),
              ]),

            Section::make('📄 Permohonan Informasi')
              ->collapsible()
              ->schema([
                TextEntry::make('rincian_informasi')
                  ->label('Rincian Informasi')
                  ->columnSpanFull(),
                TextEntry::make('tujuan_permohonan')
                  ->label('Tujuan Permohonan')
                  ->columnSpanFull(),
                TextEntry::make('cara_memperoleh_informasi')->label('Cara Memperoleh Informasi'),
                TextEntry::make('mendapatkan_salinan')->label('Mendapatkan Salinan'),
                TextEntry::make('cara_mendapatkan_salinan')->label('Cara Mendapatkan Salinan'),
                TextEntry::make('tanggal_diajukan')->label('Tanggal Diajukan')->dateTime('d M Y'),
              ]),

            Section::make('🖼️ Foto KTP')
              ->collapsible()
              ->schema([
                ImageEntry::make('foto_ktp')
                  ->disk('public')
                  ->label('')
                  ->circular(false) // biar tetap kotak
                  ->extraImgAttributes(['class' => 'rounded-md shadow max-h-70']),
              ]),

            Section::make('📌 Status Permohonan')
              ->collapsible()
              ->schema([
                TextEntry::make('status')
                  ->label('Status')
                  ->badge()
                  ->formatStateUsing(fn($state) => match ($state) {
                    'Pending'   => 'Pending',
                    'Disetujui' => 'Disetujui',
                    'Ditolak'   => 'Ditolak',
                  })
                  ->color(fn($state) => match ($state) {
                    'Pending'   => 'warning',
                    'Disetujui' => 'success',
                    'Ditolak'   => 'danger',
                  }),

                TextEntry::make('catatan')
                  ->label('Catatan')
                  ->placeholder('-')
                  ->hidden(fn($state) => blank($state)), // sembunyikan kalau kosong
              ]),
          ]),
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
      'index'  => Pages\ListPermohonanInformasis::route('/'),
      'create' => Pages\CreatePermohonanInformasi::route('/create'),
      'edit'   => Pages\EditPermohonanInformasi::route('/{record}/edit'),
    ];
  }
}
