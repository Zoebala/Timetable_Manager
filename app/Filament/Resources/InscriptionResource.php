<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use App\Models\Etudiant;
use Filament\Forms\Form;
use App\Models\Promotion;
use Filament\Tables\Table;
use App\Models\Departement;
use App\Models\Inscription;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InscriptionResource\Pages;
use App\Filament\Resources\InscriptionResource\RelationManagers;
use App\Filament\Resources\InscriptionResource\Widgets\CreateInscriptionWidget;

class InscriptionResource extends Resource
{
    protected static ?string $model = Inscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup ="University Management";
    protected static ?int $navigationSort = 9;
    public static function getNavigationBadge():string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgecolor():string|array|null
    {
        return static::getModel()::count() > 5 ? 'success' : 'success';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make("Prenez votre Inscription")
                ->icon("heroicon-o-clipboard-document-list")
                ->schema([

                    Select::make("annee_id")
                    ->label("Annee Académique")
                    ->options(function(){
                        return Annee::query()->pluck("debut","id");
                    })
                    ->required()
                    ->columnSpan(1),
                    Select::make("departement_id")
                    ->label("Departement")
                    ->options(function(){
                        return Departement::query()->pluck("lib","id");
                    })
                    ->required()
                    ->columnSpan(1),
                    Select::make("promotion_id")
                    ->label("Promotion")
                    ->options(function(){
                        return Promotion::query()->pluck("lib","id");
                    })
                    ->required()
                    ->columnSpan(1),
                    Select::make("etudiant_id")
                    ->label("Etudiant")
                    ->options(function(){
                        return Etudiant::query()->pluck("noms","id");
                    })
                    ->required()
                    ->columnSpan(1),
                    Toggle::make("actif")
                    ->label("Actif")
                ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("annee.debut")
                ->label("Année Début")
                ->searchable()
                ->toggleable(),
                TextColumn::make("annee.fin")
                ->label("Année Fin")
                ->searchable()
                ->toggleable(),
                TextColumn::make("departement.lib")
                ->label("Département")
                ->searchable()
                ->toggleable(),
                TextColumn::make("promotion.lib")
                ->label("Promotion")
                ->searchable()
                ->toggleable(),
                TextColumn::make("etudiant.noms")
                ->label("Etudiant")
                ->searchable()
                ->toggleable(),
                ToggleColumn::make("actif")
                ->label("Actif")

            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInscriptions::route('/'),
            'create' => Pages\CreateInscription::route('/create'),
            'edit' => Pages\EditInscription::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CreateInscriptionWidget::class,
        ];
    }
}
