<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Universite;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UniversiteResource\Pages;
use App\Filament\Resources\UniversiteResource\RelationManagers;
use App\Filament\Resources\UniversiteResource\Widgets\CreateUniversiteWidget;

class UniversiteResource extends Resource
{
    protected static ?string $model = Universite::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup ="University Management";
    protected static ?string $recordTitleAttribute ="lib";

    protected static ?int $navigationSort = 2;
    public static function getGlobalSearchResultTitle(Model $record):string
    {
        return $record->lib;
    }
    public static function getGloballySearchableAttributes():array
    {
        return [
            "lib",

        ];
    }
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

                Wizard::make([
                    Step::make('Informations')
                    ->schema([
                        // ...
                        Section::make("")
                        ->schema([
                            TextInput::make("lib")
                            ->label("Dénomination Institutionn")
                            ->required()
                            ->placeholder("Ex: Oxford University")
                            ->columnSpan(1),
                            TextInput::make("codepostal")
                            ->label("Code Postal")
                            ->placeHolder("Ex: 127")
                            ->columnSpan(1),
                            TextInput::make("ville")
                            ->required()
                            ->placeholder("Ex: Mbanza-ngungu")
                            ->maxlength(50),
                            TextInput::make("adresse")
                            ->required()
                            ->placeholder("Ex: 13, Av. Réservoir Q/Noki")
                            ->maxlength(50),
                            TextInput::make("email")
                            ->required()
                            ->email()
                            ->placeholder("Ex: universite@example.com")
                            ->columnspan(2),
                            ])->columns(2)->columnspan(2),
                         Section::make()
                        ->icon("heroicon-o-camera")
                        ->description("Profile de votre Institution")
                        ->schema([
                                FileUpload::make("photo")
                                ->disk("public")->directory("photos")
                            ])->columnspan(1),
                    ])->columns(3),
                    Step::make("Description")
                    ->schema([

                        MarkdownEditor::make("description")
                        ->columnSpanfull()
                    ])
                ])->columnSpanFull()->columns(2),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("lib")
                ->label("Dénomination")
                ->toggleable()
                ->searchable(),
                TextColumn::make("ville")
                ->toggleable()
                ->searchable(),
                TextColumn::make("codepostal")
                ->label("Code Postal")
                ->toggleable()
                ->searchable(),
                ImageColumn::make("photo"),
                TextColumn::make("email")
                ->toggleable()
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
            CreateUniversiteWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUniversites::route('/'),
            'create' => Pages\CreateUniversite::route('/create'),
            'edit' => Pages\EditUniversite::route('/{record}/edit'),
        ];
    }
}
