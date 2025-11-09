<?php

namespace App\Filament\AdminPPID\Resources;

use App\Filament\AdminPPID\Resources\PengajuanKeberatanResource\Pages;
use App\Filament\AdminPPID\Resources\PengajuanKeberatanResource\RelationManagers;
use App\Models\PengajuanKeberatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PengajuanKeberatanResource extends Resource
{
  protected static ?string $model = PengajuanKeberatan::class;

  protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

  public static function getNavigationGroup(): ?string
  {
    return 'Pengajuan & Keberatan Informasi Publik';
  }

  public static function getNavigationLabel(): string
  {
    return 'Pengajuan Keberatan';
  }

  public static function getPluralLabel(): string
  {
    return 'Pengajuan Keberatan';
  }

  public static function getModelLabel(): string
  {
    return 'Pengajuan Keberatan';
  }

  public static function getSlug(): string
  {
    return 'pengajuan-keberatan';
  }

  public static function canCreate(): bool
  {
    return false;
  }

  public static function canAccess(): bool
  {
    return Auth::user()->role == 'admin-ppid';
  }

  public static function getNavigationBadge(): ?string
  {
    $count = static::getModel()::where('status', 'Pending')->count();
    return $count > 0 ? (string) $count : null;
  }

  public static function getNavigationBadgeColor(): ?string
  {
    return 'warning';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Data Pengajuan')
          ->schema([
            Forms\Components\TextInput::make('nomor_registrasi')
              ->required()
              ->readOnly()
              ->label('Nomor Registrasi'),
            Forms\Components\TextInput::make('nomor_ktp')
              ->required()
              ->label('Nomor KTP'),
            Forms\Components\Select::make('status')
              ->options([
                'Pending' => 'Pending',
                'Selesai' => 'Selesai',
              ])
              ->default('Pending')
              ->required(),
            Forms\Components\Textarea::make('catatan')
              ->label('Catatan'),
            Forms\Components\Textarea::make('tujuan_penggunaan')
              ->label('Tujuan Penggunaan Informasi'),
            Forms\Components\Textarea::make('kasus_posisi')
              ->label('Kasus Posisi')
              ->required(),
            Forms\Components\Radio::make('alasan')
              ->options([
                'Permohonan informasi ditolak'                                   => 'Permohonan informasi ditolak',
                'Informasi berkala tidak disediakan'                             => 'Informasi berkala tidak disediakan',
                'Permintaan informasi tidak ditanggapi'                          => 'Permintaan informasi tidak ditanggapi',
                'Permintaan informasi ditanggapi tidak sebagaimana yang diminta' => 'Permintaan informasi ditanggapi tidak sebagaimana yang diminta',
                'Permintaan informasi tidak terpenuhi'                           => 'Permintaan informasi tidak terpenuhi',
                'Biaya yang dikenakan tidak wajar'                               => 'Biaya yang dikenakan tidak wajar',
                'Informasi disampaikan melebihi jangka waktu yang ditentukan'    => 'Informasi disampaikan melebihi jangka waktu yang ditentukan',
              ])
              ->inline()
              ->required(),
            Forms\Components\DatePicker::make('tanggal_diajukan')
              ->label('Tanggal Diajukan')
              ->default(now())
              ->required(),
          ])
          ->columns(2),

        Forms\Components\Section::make('Identitas Pemohon')
          ->schema([
            Forms\Components\TextInput::make('nama_pemohon')->required(),
            Forms\Components\Textarea::make('alamat_pemohon')->required(),
            Forms\Components\TextInput::make('pekerjaan')->required(),
            Forms\Components\TextInput::make('no_hp_pemohon')->required(),
          ])
          ->columns(2),

        Forms\Components\Section::make('Identitas Kuasa Pemohon')
          ->schema([
            Forms\Components\TextInput::make('nama_kuasa_pemohon'),
            Forms\Components\Textarea::make('alamat_kuasa_pemohon'),
            Forms\Components\TextInput::make('no_hp_kuasa_pemohon'),
          ])
          ->columns(2),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('#')
          ->label('#')
          ->rowIndex()
          ->width('7%'),

        Tables\Columns\TextColumn::make('nomor_registrasi')
          ->label('No Registrasi')
          ->searchable()
          ->sortable(),

        Tables\Columns\TextColumn::make('nama_pemohon')
          ->label('Nama Pemohon')
          ->searchable()
          ->sortable(),

        // Tables\Columns\TextColumn::make('no_hp_pemohon')
        //   ->label('No HP'),

        // Tables\Columns\TextColumn::make('email'),

        Tables\Columns\TextColumn::make('alasan')
          ->label('Alasan Pengajuan')
          ->limit(40), // tampil sebagian

        Tables\Columns\TextColumn::make('tanggal_diajukan')
          ->label('Diajukan')
          ->dateTime('d M Y'),

        // Kolom Status
        Tables\Columns\TextColumn::make('status')
          ->label('Status')
          ->formatStateUsing(function ($state) {
            return match ($state) {
              'Pending' => 'Pending',
              'Selesai' => 'Selesai',
            };
          })
          ->badge()
          ->color(fn($state) => match ($state) {
            'Pending' => 'warning',   // kuning
            'Selesai' => 'success',   // hijau
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
                'Selesai' => 'Selesai',
              ])
              ->required(),

            Forms\Components\Textarea::make('catatan')
              ->label('Catatan')
              ->placeholder('Tambahkan catatan...')
              ->rows(4),
          ])
          ->fillForm(function ($record) {
            return [
              'status'   => $record->status,
              'catatan'  => $record->catatan,
            ];
          })
          ->action(function ($record, array $data) {
            $record->update([
              'status'   => $data['status'],
              'catatan'  => $data['catatan'] ?? null,
            ]);
          })
          ->modalHeading('Konfirmasi Pengajuan Keberatan')
          ->modalButton('Simpan'),

        Tables\Actions\ViewAction::make()
          ->label('Detail')
          ->infolist([
            Section::make('🧑 Identitas Pemohon')
              ->collapsible()
              ->schema([
                TextEntry::make('nama_pemohon')->label('Nama Pemohon'),
                TextEntry::make('nomor_ktp')->label('Nomor KTP'),
                TextEntry::make('alamat_pemohon')->label('Alamat Pemohon')->columnSpanFull(),
                TextEntry::make('pekerjaan')->label('Pekerjaan'),
                TextEntry::make('no_hp_pemohon')->label('Nomor HP Pemohon'),
              ]),

            Section::make('👥 Identitas Kuasa Pemohon')
              ->collapsible()
              ->schema([
                TextEntry::make('nama_kuasa_pemohon')->label('Nama Kuasa Pemohon')->placeholder('-'),
                TextEntry::make('alamat_kuasa_pemohon')->label('Alamat Kuasa Pemohon')->placeholder('-')->columnSpanFull(),
                TextEntry::make('no_hp_kuasa_pemohon')->label('Nomor HP Kuasa Pemohon')->placeholder('-'),
              ]),

            Section::make('📄 Pengajuan Keberatan')
              ->collapsible()
              ->schema([
                TextEntry::make('nomor_registrasi')->label('Nomor Registrasi'),
                TextEntry::make('tujuan_penggunaan')->label('Tujuan Penggunaan')->columnSpanFull(),
                TextEntry::make('kasus_posisi')->label('Kasus Posisi')->columnSpanFull(),
                TextEntry::make('alasan')->label('Alasan Pengajuan Keberatan'),
                TextEntry::make('tanggal_diajukan')->label('Tanggal Diajukan')->dateTime('d M Y'),
              ]),

            Section::make('📌 Status')
              ->collapsible()
              ->schema([
                TextEntry::make('status')
                  ->label('Status')
                  ->badge()
                  ->formatStateUsing(fn($state) => match ($state) {
                    'Pending' => 'Pending',
                    'Selesai' => 'Selesai',
                    default   => $state,
                  })
                  ->color(fn($state) => match ($state) {
                    'Pending' => 'warning',
                    'Selesai' => 'success',
                    default   => 'secondary',
                  }),

                TextEntry::make('catatan')
                  ->label('Catatan')
                  ->placeholder('-')
                  ->hidden(fn($state) => blank($state)),
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
      'index'  => Pages\ListPengajuanKeberatans::route('/'),
      'create' => Pages\CreatePengajuanKeberatan::route('/create'),
      'edit'   => Pages\EditPengajuanKeberatan::route('/{record}/edit'),
    ];
  }
}
