<?php

namespace App\Filament\Resources\SectionResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class DepartementsRelationManager extends RelationManager
{
    protected static string $relationship = 'departements';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                    TextInput::make('lib')
                    ->label("Departement")
                    ->required()
                    ->maxLength(255),
                    MarkdownEditor::make('description')
                    ->label("Description")
                    ->required()
                    ->maxLength(255)->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('lib')
            ->columns([
                TextColumn::make('lib')
                ->label("Departement")
                ->searchable()
                ->toggleable(),
                TextColumn::make('description')
                ->label("Description")
                ->searchable()
                ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
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
