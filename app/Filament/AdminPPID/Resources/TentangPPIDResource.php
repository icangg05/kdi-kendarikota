<?php

namespace App\Filament\AdminPPID\Resources;

use App\Filament\AdminPPID\Resources\TentangPPIDResource\Pages;
use App\Filament\AdminPPID\Resources\TentangPPIDResource\RelationManagers;
use App\Models\PPID;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TentangPPIDResource extends Resource
{
  protected static ?string $model = PPID::class;

  protected static ?string $navigationIcon = 'heroicon-o-document-text';

  public static function getNavigationGroup(): ?string
  {
    return 'PPID Kota Kendari';
  }

  public static function getNavigationLabel(): string
  {
    return 'Tentang PPID';
  }

  public static function getPluralLabel(): string
  {
    return 'Tentang PPID';
  }

  public static function getModelLabel(): string
  {
    return 'Tentang PPID';
  }

  public static function getSlug(): string
  {
    return 'tentang-ppid';
  }

  public static function canCreate(): bool
  {
    return false;
  }

  public static function canDelete(Model $record): bool
  {
    return false;
  }

  public static function canAccess(): bool
  {
    return Auth::user()->role == 'admin-ppid';
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        \Filament\Forms\Components\Card::make()->schema([

          \Filament\Forms\Components\Grid::make(3)->schema([

            \Filament\Forms\Components\Grid::make(1)->schema([
              Forms\Components\TextInput::make('label')
                ->label('Nama Menu')
                ->required(),
              Forms\Components\Hidden::make('slug'),
              Forms\Components\RichEditor::make('konten')
                ->label('Isi Konten')
                ->fileAttachmentsDisk('public')
                ->fileAttachmentsDirectory('richeditor')
                ->disableGrammarly()
                ->required(),

            ])->columnSpan(2),

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
          ])
        ])
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        \Filament\Tables\Columns\TextColumn::make('#')
          ->label('#')
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),

        \Filament\Tables\Columns\TextColumn::make('label')
          ->label('Nama Menu')
          ->wrap()
          ->searchable(),

        \Filament\Tables\Columns\TextColumn::make('konten')
          ->label('Isi Konten')
          ->formatStateUsing(
            fn($state) => str()->of(html_entity_decode($state ?? ''))
              ->stripTags()      // buang semua <tag>
              ->squish()         // rapikan spasi berlebih
              ->words(25)
              ->toString()
          )
          ->wrap()               // biar teks membungkus
          ->searchable(),

        \Filament\Tables\Columns\TextColumn::make('lampiran')
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
      'index' => Pages\ListTentangPPIDS::route('/'),
      'create' => Pages\CreateTentangPPID::route('/create'),
      'edit' => Pages\EditTentangPPID::route('/{record}/edit'),
    ];
  }
}
