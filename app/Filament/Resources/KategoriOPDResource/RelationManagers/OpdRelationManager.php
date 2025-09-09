<?php

namespace App\Filament\Resources\KategoriOPDResource\RelationManagers;

use App\Models\OPD;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class OpdRelationManager extends RelationManager
{
  protected static string $relationship = 'opd';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Grid::make(2)
          ->schema([
            Forms\Components\Grid::make(1)
              ->schema([
                Forms\Components\TextInput::make('nama')
                  ->required()
                  ->placeholder('Nama')
                  ->maxLength(255),
                Forms\Components\Select::make('kategori_opd_id')
                  ->label('Kategori OPD')
                  ->relationship('kategori', 'nama')
                  ->required()
                  ->preload()
                  ->searchable(),
              ])->columnSpan(1),

            Forms\Components\Grid::make(1)
              ->schema([
                Forms\Components\FileUpload::make('files')
                  ->label('Upload Dokumen')
                  ->directory('dokumen')
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
                  })
              ])->columnSpan(1),
          ])
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('nama')
      ->defaultSort('id', 'desc')
      ->recordAction(null)
      ->columns([
        Tables\Columns\TextColumn::make('#')
          ->label('#')
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),
        Tables\Columns\TextColumn::make('nama')
          ->searchable()
          ->sortable(),
        Tables\Columns\TextColumn::make('files')
          ->label('File')
          ->badge()
          ->color(fn($state) => $state ? 'primary' : 'gray')
          ->formatStateUsing(function ($state) {
            if (blank($state)) {
              return 'Tidak ada';
            }

            $files = is_array($state) ? $state : explode(',', $state);
            $first = trim($files[0] ?? '');

            return $first !== '' ? 'Lihat File' : 'Tidak ada';
          })
          ->extraAttributes(function ($record) {
            if (blank($record->files)) {
              return ['style' => 'cursor: not-allowed;'];
            }

            $files = is_array($record->files) ? $record->files : explode(',', $record->files);
            $first = trim($files[0] ?? '');

            if ($first === '') {
              return ['style' => 'cursor: not-allowed;'];
            }

            $url = asset('storage/' . ltrim($first, '/'));

            return [
              'onclick' => "window.open('{$url}', 'popup', 'width=800,height=600,scrollbars=yes,resizable=yes'); return false;",
              'style'   => 'cursor: pointer;',
            ];
          })



      ])
      ->filters([
        //
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make(),
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }
}
