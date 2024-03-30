<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Universite;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UniversiteResource\Pages;
use App\Filament\Resources\UniversiteResource\RelationManagers;

class UniversiteResource extends Resource
{
    protected static ?string $model = Universite::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup ="University Management";
    protected static ?int $navigationSort = 1;
    public static function getNavigationBadge():string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgecolor():string|array|null
    {
        return static::getModel()::count() > 5 ? 'success' : 'warning';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                    ->placeholder("Ex: universite@example.com"),
                    MarkdownEditor::make("description")
                ])->columns(2),
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
            'index' => Pages\ListUniversites::route('/'),
            'create' => Pages\CreateUniversite::route('/create'),
            'edit' => Pages\EditUniversite::route('/{record}/edit'),
        ];
    }
}
