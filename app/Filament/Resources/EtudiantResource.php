<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Etudiant;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EtudiantResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EtudiantResource\RelationManagers;
use App\Filament\Resources\EtudiantResource\Widgets\CreateEtudiantWidget;

class EtudiantResource extends Resource
{
    protected static ?string $model = Etudiant::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup ="University Management";
    protected static ?int $navigationSort = 8;
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
                    DatePicker::make("datenais")
                    ->label("Date de Naissance")
                   ->required()
                   ->columnSpan(1),
                   TextInput::make("adresse")
                   ->label("Adresse")
                   ->placeholder("Ex: 13, Av. Mobutu Q/Loma")
                   ->columnSpan(1),
                   TextInput::make("email")
                  ->email()
                  ->unique("etudiants")
                  ->placeholder("Ex: enseignant@exemple.com")
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
            'index' => Pages\ListEtudiants::route('/'),
            'create' => Pages\CreateEtudiant::route('/create'),
            'edit' => Pages\EditEtudiant::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CreateEtudiantWidget::class,
        ];
    }
}
