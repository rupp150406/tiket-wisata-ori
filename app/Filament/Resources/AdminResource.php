<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Admin;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AdminResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AdminResource\RelationManagers;
use Dom\Text;

class AdminResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                TextInput::make('name'),
                Select::make('category')
                ->options([
                    'event' => 'acara',
                    'perjalanan' => 'destinasi',
                    'hotel' => 'hotel',
                ]),
                TextInput::make('description')
                ->minLength(2)
                ->maxLength(1000),
                TextInput::make('location')
                ->minLength(2)
                ->maxLength(1000),
                TextInput::make('price')
                ->numeric(),
                ])->columns(2),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')
            ->sortable()
            ->searchable(),
            TextColumn::make('category')
            ->sortable()
            ->searchable(),
            TextColumn::make('description')
            ->sortable()
            ->searchable(),
            TextColumn::make('price')
            ->sortable()
            ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAdmins::route('/'),
        ];
    }
}
