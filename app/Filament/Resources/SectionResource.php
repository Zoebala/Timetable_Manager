<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Section as Sections;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\SectionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SectionResource\RelationManagers;

class SectionResource extends Resource
{
    protected static ?string $model = Sections::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup ="University Management";
    protected static ?int $navigationSort = 3;
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
                Section::make("")
                ->schema([
                    Select::make("universite_id")
                    ->label("Universite")
                    ->relationship('universite',"lib")
                    ->live()
                    ->required()
                    ->columnspan(1),
                    TextInput::make("lib")
                    ->label("Section")
                    ->disabled(fn(Get $get):bool => !filled($get("universite_id")))
                    ->live()
                    ->required()
                    // ->maxlength(50)
                    ->placeholder("Ex: Sciencs et technologies")
                    ->columnspan(1),
                    MarkdownEditor::make("description")
                    ->columnSpanFull()
                    ->hidden(fn(Get $get):bool => !filled($get("lib"))),
                ])->columns(2),
                //gestion de département
                Toggle::make("Depart")
                ->label(function(Get $get){
                    if($get('Depart')==false){
                        return "Renseigner ses départements?";
                    }else{
                        return "Ne pas renseigner ses départements ?";
                    }
                })
                ->live(),
                Section::make("")
                ->schema([
                    Repeater::make("departements")
                    ->label("Departement")
                    ->relationship()
                    ->schema([
                        Wizard::make([
                            Step::make("Information")
                            ->schema([
                                TextInput::make("lib")
                                ->label("Departement")
                                ->live()
                                ->placeholder("Ex: Info et technologies"),

                            ]),
                            Step::make("Description")
                            ->schema([
                                MarkdownEditor::make("departements.description")
                                ->label("Description")
                                ->disabled(fn(Get $get):bool => !filled($get("lib")))

                            ]),

                        ]),

                    ])
                ])->hidden(fn(Get $get):bool => $get("Depart")==false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
