<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cours;
use Filament\Forms\Form;
use App\Models\Promotion;
use Filament\Tables\Table;
use App\Models\Departement;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\CoursResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CoursResource\RelationManagers;
use App\Filament\Resources\CoursResource\Widgets\CreateCoursWidget;

class CoursResource extends Resource
{
    protected static ?string $model = Cours::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup ="University Management";
    protected static ?int $navigationSort = 6;
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
                Wizard::make([
                    Step::make("Informations Cours")
                    ->schema([
                        Section::make("")
                        ->schema([
                            Select::make("departement_id")
                            ->label("Departement")
                            ->options(function(){
                                return Departement::query()->pluck("lib","id");
                            })
                            ->required()
                            ->searchable()
                            ->preload(),
                            Select::make("promotion_id")
                            ->label("Promotion")
                            ->options(function(){
                                return Promotion::query()->pluck("lib","id");
                            })
                            ->searchable()
                            ->required()
                            ->preload(),
                            TextInput::make("lib")
                            ->label("Cours")
                            ->required()
                            ->placeholder("Ex: Statistique")
                            ->columnSpan(1),
                            TextInput::make("credit")
                            ->label("Crédit")
                            ->integer()
                            ->placeholder("Ex: 1")
                            ->minValue(1),

                        ])->columns(2),

                    ]),
                    Step::make("Description")
                    ->schema([
                        MarkdownEditor::make("description")

                    ])
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("departement.lib")
                ->label("Departement")
                ->searchable()
                ->toggleable(),
                TextColumn::make("promotion.lib")
                ->label("Promotion")
                ->searchable()
                ->toggleable(),
                TextColumn::make("lib")
                ->label("Cours")
                ->searchable()
                ->toggleable(),
                TextColumn::make("credit")
                ->label("Crédit")
                ->searchable()
                ->toggleable(),
                TextColumn::make("description")
                ->label("Description")
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
            'index' => Pages\ListCours::route('/'),
            'create' => Pages\CreateCours::route('/create'),
            'edit' => Pages\EditCours::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            CreateCoursWidget::class,
        ];
    }
}
