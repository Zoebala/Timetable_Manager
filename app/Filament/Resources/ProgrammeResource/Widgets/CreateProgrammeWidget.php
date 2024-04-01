<?php

namespace App\Filament\Resources\ProgrammeResource\Widgets;

use App\Models\Cours;
use App\Models\Salle;
use Filament\Forms\Form;
use App\Models\Programme;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateProgrammeWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.resources.programme-resource.widgets.create-programme-widget';

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
            ])->columns(3)->statePath("data");
    }

    public function create(): void
    {
        Programme::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('programme-created');

        Notification::make()
        ->title('Enregistrement effectué avec succès')
        ->success()
         ->duration(5000)
        ->send();
    }

}
