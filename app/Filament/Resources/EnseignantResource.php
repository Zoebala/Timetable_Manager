<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Enseignant;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EnseignantResource\Pages;
use App\Filament\Resources\EnseignantResource\RelationManagers;
use App\Filament\Resources\EnseignantResource\Widgets\CreateEnseignantWidget;

class EnseignantResource extends Resource
{
    protected static ?string $model = Enseignant::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup ="University Management";
    protected static ?int $navigationSort = 7;
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
                    TextInput::make("matricule")
                    ->columnspan(1),
                    TextInput::make("noms")
                    ->required()
                    ->placeholder("Ex: Matondo Kuanzambi lorette")
                    ->columnSpan(1),
                    TextInput::make("tel")
                    ->label("Téléphone")
                    ->required()
                    ->placeholder("Ex: 0896071804")
                    ->maxlength(10),
                    TextInput::make("fonction")
                    ->label("Fonction")
                   ->placeholder("Choisir(double clic) ou éditer votre fonction")
                   ->required()
                   ->datalist(
                       [

                           "Professeur Ordinaire" =>"Professeur Ordinaire",
                           "Professeur Associé"=>"Professeur Associé",
                           "Professeur"=>"Professeur",
                           "Chef de Travaux"=>"Chef de Travaux",
                           "Assistant" =>"Assistant",
                       ]
                   )
                   ->columnSpan(1),
                     TextInput::make("email")
                    ->email()
                    ->placeholder("Ex: enseignant@exemple.com")
                    ->columnSpan(1),
                     TextInput::make("adresse")
                     ->label("Adresse")
                    ->placeholder("Ex: 13, Av. Mobutu Q/Loma")
                    ->columnSpan(1),

                ])->columns(2)->columnSpan(2),
                Section::make("Votre profil")
                ->icon("heroicon-o-user")
                ->schema([
                    FileUpload::make("photo")
                    ->disk("public")->directory("photos"),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("matricule")
                ->searchable()
                ->toggleable(),
                TextColumn::make("noms")
                ->label("Noms")
                ->searchable()
                ->toggleable(),
                ImageColumn::make("photo"),
                TextColumn::make("email")
                ->searchable()
                ->toggleable(),
                TextColumn::make("tel")
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
            'index' => Pages\ListEnseignants::route('/'),
            'create' => Pages\CreateEnseignant::route('/create'),
            'edit' => Pages\EditEnseignant::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CreateEnseignantWidget::class,
        ];
    }
}
