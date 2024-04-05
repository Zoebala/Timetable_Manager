<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cours;
use App\Models\Salle;
use Filament\Forms\Form;
use App\Models\Programme;
use App\Models\Enseignant;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\ProgrammeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProgrammeResource\RelationManagers;
use App\Filament\Resources\ProgrammeResource\Widgets\CreateProgrammeWidget;

class ProgrammeResource extends Resource
{
    protected static ?string $model = Programme::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup ="University Management";
    protected static ?int $navigationSort = 11;
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
                Section::make("Définition de l'horaire de cours")
                ->icon("heroicon-o-calendar-days")
                ->schema([
                    Select::make("cours_id")
                    ->label("Cours")
                    ->options(function(){
                        return Cours::query()->pluck("lib","id");
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->placeholder("Ex: Informatique Générale")
                    ->columnSpan(1),
                    Select::make("salle_id")
                    ->label("Salle")
                    ->options(function(){
                        return Salle::query()->pluck("lib","id");
                    })
                    ->searchable()
                    ->preload()
                    ->placeholder("Ex: Auditorium")
                    ->required()
                    ->columnSpan(1),

                    TimePicker::make("debut")
                    ->label("Heure Début")
                    ->columnSpan(1)
                    ->required(),
                    TimePicker::make("fin")
                    ->label("Heure Fin")
                    ->columnSpan(1)
                    ->required(),
                    Select::make("enseignant_id")
                    ->label("Enseignant")
                    ->options(function(){
                        return Enseignant::query()->pluck("noms","id");
                    })
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
                ])->columns(2)->columnSpan(2),
                Section::make("Jours de prestations du cours")
                ->Icon("heroicon-o-calendar-days")
                ->schema([
                    CheckboxList::make('jours')
                    ->label("Jours")
                    ->options([
                        'Lundi' => 'Lundi',
                        'Mardi' => 'Mardi',
                        'Mercredi' => 'Mercredi',
                        'Jeudi' => 'Jeudi',
                        'Vendredi' => 'Vendredi',
                        'Samedi' => 'Samedi',
                        'Dimanche' => 'Dimanche',
                    ])->columns(2)->columnspan(1)
                    ->required(),
                ])->columnspan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("cours.lib")
                ->label('Cours')
                ->searchable()
                ->toggleable(),
                TextColumn::make("salle.lib")
                ->label('Salle')
                ->searchable()
                ->toggleable(),
                TextColumn::make("debut")
                ->label('Heure Début')
                ->searchable()
                ->toggleable(),
                TextColumn::make("fin")
                ->label('Heure Fin')
                ->searchable()
                ->toggleable(),
                TextColumn::make("jours")
                ->label('Jours')
                ->searchable()
                ->toggleable(),
                TextColumn::make("enseignant.noms")
                ->label('Enseignant')
                ->searchable()
                ->toggleable(),

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
            'index' => Pages\ListProgrammes::route('/'),
            'create' => Pages\CreateProgramme::route('/create'),
            'edit' => Pages\EditProgramme::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CreateProgrammeWidget::class,
        ];
    }
}
