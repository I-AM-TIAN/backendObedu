<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoletinResource\Pages;
use App\Filament\Resources\BoletinResource\RelationManagers;
use App\Models\Autor;
use App\Models\Boletin;
use App\Models\Categoria;
use App\Models\Tipo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BoletinResource extends Resource
{
    protected static ?string $model = Boletin::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('tipo_id')
                    ->relationship('tipo', 'nombre')
                    ->options(Tipo::all()->pluck('nombre', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('titulo')->required(),
                Forms\Components\Textarea::make('contenido')->required(),
                Forms\Components\FileUpload::make('imagen')->image(),
                Forms\Components\DatePicker::make('fecha')->required(),
                Forms\Components\FileUpload::make('pdf')
                    ->acceptedFileTypes(['application/pdf'])
                    ->visible(fn(callable $get) => $get('tipo_id') && Tipo::find($get('tipo_id'))->nombre === 'Investigacion')
                    ->reactive(),
                Forms\Components\Select::make('categoria_id')
                    ->relationship('categoria', 'nombre')
                    ->options(Categoria::all()->pluck('nombre', 'id'))
                    ->searchable()
                    ->required(),
                // Selección de múltiples autores
                Forms\Components\Select::make('autores')
                    ->relationship('autores', 'primerNombre')
                    ->options(Autor::all()->pluck('primerNombre', 'id'))
                    ->multiple()
                    ->searchable(),

                // Repetidor para los párrafos
                Forms\Components\Repeater::make('parrafos')
                    ->relationship('parrafos')
                    ->schema([
                        Forms\Components\Textarea::make('contenido')->required(),
                    ])
                    ->minItems(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imagen')
                    ->label('Imagen'),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable()
                    ->label('Titulo'),
                Tables\Columns\TextColumn::make('fecha')
                    ->searchable()
                    ->label('Fecha'),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->searchable()
                    ->label('Categoria'),
                Tables\Columns\TextColumn::make('tipo.nombre')
                    ->searchable()
                    ->label('Tipo'),
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
            'index' => Pages\ListBoletins::route('/'),
            'create' => Pages\CreateBoletin::route('/create'),
            'edit' => Pages\EditBoletin::route('/{record}/edit'),
        ];
    }
}
