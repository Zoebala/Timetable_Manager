<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Departement;
use Filament\Resources\Resource;
use App\Models\Section as Sections;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DepartementResource\Pages;
use App\Filament\Resources\DepartementResource\RelationManagers;
use App\Filament\Resources\DepartementResource\Widgets\CreateDepartementWidget;

class DepartementResource extends Resource
{
    protected static ?string $model = Departement::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup ="University Management";
    protected static ?int $navigationSort = 4;
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
                    Step::make("Informations Département")
                    ->schema([
                        Section::make("")
                        ->schema([
                            Select::make("section_id")
                            ->label("Section")
                            ->options(function(){
                            return Sections::query()->pluck("lib","id");
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnspan(1),
                            TextInput::make("lib")
                            ->label("Departement")
                            ->placeholder("Ex: économie")
                            ->live()
                            ->required()
                        ])->columns(2),

                    ]),
                    Step::make("Description")
                    ->schema([
                        MarkdownEditor::make("description")
                        ->disabled(fn(Get $get):bool => !filled($get("lib")))
                    ]),

                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("section.lib")
                ->label("Section")
                ->searchable()
                ->toggleable(),
                TextColumn::make("lib")
                ->label("Département")
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
            'index' => Pages\ListDepartements::route('/'),
            'create' => Pages\CreateDepartement::route('/create'),
            'edit' => Pages\EditDepartement::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
           CreateDepartementWidget::class,
        ];
    }
}
