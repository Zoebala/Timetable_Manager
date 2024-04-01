<?php

namespace App\Filament\Resources\EnseignantResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class CoursRelationManager extends RelationManager
{
    protected static string $relationship = 'cours';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                    TextInput::make('lib')
                    ->label("Cours")
                    ->required()
                    ->maxLength(255),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('lib')
            ->columns([
                TextColumn::make('lib')
                ->label("Cours")
                ->searchable()
                ->toggleable(),
                TextColumn::make('credit')
                ->label("Crédit")
                ->searchable()
                ->toggleable(),
                TextColumn::make('promotion.lib')
                ->label("Promotion")
                ->searchable()
                ->toggleable(),
                TextColumn::make('departement.lib')
                ->label("Departement")
                ->searchable()
                ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
