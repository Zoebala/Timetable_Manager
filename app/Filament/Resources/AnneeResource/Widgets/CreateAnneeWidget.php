<?php

namespace App\Filament\Resources\AnneeResource\Widgets;

use App\Models\Annee;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateAnneeWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.resources.annee-resource.widgets.create-annee-widget';
    protected int | string | array $columnSpan = 'full';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make("Définition d'une année Académique")
                ->icon("heroicon-o-calendar-days")
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
            ])->statePath('data');;
    }

    public function create(): void
    {
        Annee::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('Annee-created');

        Notification::make()
        ->title('Enregistrement effectué avec succès')
        ->success()
         ->duration(5000)
        ->send();
    }
}
