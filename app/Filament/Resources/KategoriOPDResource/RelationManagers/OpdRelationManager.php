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
                  ->multiple()
                  ->acceptedFileTypes(['application/pdf'])
                  ->maxSize(102400)
                  ->helperText('Max upload 100MB / file.')
                  ->maxParallelUploads(2)
                  ->saveUploadedFileUsing(function (TemporaryUploadedFile $file, $get) {
                    // Mengubah nama file menjadi slug
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $slug = str()->slug($originalName);

                    // Menambahkan 4 digit angka acak
                    $randomNumber = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT); // 4 digit angka acak

                    // Gabungkan slug dengan angka acak
                    $newFilename = $slug . '-' . $randomNumber . '.' . $file->getClientOriginalExtension();

                    // Simpan file dengan nama baru
                    return $file->storeAs('dokumen/' . date('Y'), $newFilename, 'public');
                  }),
              ])->columnSpan(1),
          ])
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('nama')
      ->defaultSort('id', 'desc')
      ->columns([
        Tables\Columns\TextColumn::make('#')
          ->label('#')
          ->state(fn($rowLoop) => $rowLoop->iteration . '.')
          ->width('7%'),
        Tables\Columns\TextColumn::make('nama')
          ->searchable()
          ->sortable(),
        BadgeColumn::make('struktur_new')
          ->label('File')
          ->color('info')
          ->formatStateUsing(fn(?string $state) => 'Lihat')
          ->url(fn(?string $state): ?string => $state ? asset("storage/$state") : null, true),
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
