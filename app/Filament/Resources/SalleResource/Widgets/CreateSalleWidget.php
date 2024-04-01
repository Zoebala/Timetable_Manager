<?php

namespace App\Filament\Resources\SalleResource\Widgets;

use App\Models\Salle;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateSalleWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.resources.salle-resource.widgets.create-salle-widget';


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
                Section::make("Définition des Salles")
                ->icon("heroicon-o-building-storefront")
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


            ])->statePath("data");
    }

    public function create(): void
    {
        Salle::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('salle-created');

        Notification::make()
        ->title('Enregistrement effectué avec succès')
        ->success()
         ->duration(5000)
        ->send();
    }
}
