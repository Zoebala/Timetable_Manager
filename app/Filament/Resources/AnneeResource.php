<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AnneeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AnneeResource\RelationManagers;
use App\Filament\Resources\AnneeResource\Widgets\CreateAnneeWidget;

class AnneeResource extends Resource
{
    protected static ?string $model = Annee::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup ="University Management";
    protected static ?int $navigationSort = 1;
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
                Section::make("Définition d'une année Académique")
                ->icon("heroicon-o-calendar")
                ->schema([

                    TextInput::make("debut")
                    ->label("Année Début")
                    ->placeholder("Ex : ". Date("Y"))
                    ->integer()
                    ->live(debounce:1200)
                    ->afterStateUpdated(fn(Get $get, Set $set)=>$set("fin",$get("debut")+1))
                    ->minValue(date("Y")-1)
                    ->maxLength(4)
                    ->required()
                     ->columnspan(1),
                    TextInput::make("fin")
                    ->label("Année Fin")
                    ->placeholder("Ex : ". Date("Y")+1)
                    ->integer()
                    ->disabled(fn(Get $get):bool => !filled($get("debut")))
                    ->minValue(date("Y")+1)
                    ->maxLength(4)
                    // ->hydrate(true)
                    ->required()
                    ->columnspan(1),

                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("debut")
                ->label("Année Début")
                ->searchable(),
                TextColumn::make("fin")
                ->label("Année Fin")
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


    public static function getWidgets(): array
    {
        return [
            CreateAnneeWidget::class,
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnees::route('/'),
            'create' => Pages\CreateAnnee::route('/create'),
            'edit' => Pages\EditAnnee::route('/{record}/edit'),
        ];
    }
}
