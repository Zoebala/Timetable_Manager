<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Salle;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SalleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SalleResource\RelationManagers;
use App\Filament\Resources\SalleResource\Widgets\CreateSalleWidget;

class SalleResource extends Resource
{
    protected static ?string $model = Salle::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup ="University Management";
    protected static ?int $navigationSort = 10;
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
                    TextInput::make("lib")
                    ->label("Salle")
                    ->columnspan(1)
                    ->placeholder("Ex: Auditorium")
                    ->required(),
                    TextInput::make("ref")
                    ->label("Référence")
                    ->placeholder("Ex: Entrée ISP/Mbanza-ngungu")
                    ->columnspan(1),

                ])->columns(2),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("lib")
                ->label("Salle")
                ->searchable()
                ->toggleable(),
                TextColumn::make("ref")
                ->label("Référence")
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
            'index' => Pages\ListSalles::route('/'),
            'create' => Pages\CreateSalle::route('/create'),
            'edit' => Pages\EditSalle::route('/{record}/edit'),
        ];
    }


    public static function getWidgets(): array
    {
        return [
            CreateSalleWidget::class,
        ];
    }


}
