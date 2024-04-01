<?php

namespace App\Filament\Resources\InscriptionResource\Widgets;

use App\Models\Annee;
use App\Models\Etudiant;
use Filament\Forms\Form;
use App\Models\Promotion;
use App\Models\Departement;
use App\Models\Inscription;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateInscriptionWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.resources.inscription-resource.widgets.create-inscription-widget';
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
                Section::make("Inscription")
                ->icon("heroicon-o-clipboard-document-list")
                ->schema([

                    Select::make("annee_id")
                    ->label("Annee Académique")
                    ->options(function(){
                        return Annee::query()->pluck("debut","id");
                    })
                    ->required()
                    ->columnSpan(1),
                    Select::make("departement_id")
                    ->label("Departement")
                    ->options(function(){
                        return Departement::query()->pluck("lib","id");
                    })
                    ->required()
                    ->columnSpan(1),
                    Select::make("promotion_id")
                    ->label("Promotion")
                    ->options(function(){
                        return Promotion::query()->pluck("lib","id");
                    })
                    ->required()
                    ->columnSpan(1),
                    Select::make("etudiant_id")
                    ->label("Etudiant")
                    ->options(function(){
                        return Etudiant::query()->pluck("noms","id");
                    })
                    ->required()
                    ->columnSpan(1),
                    Toggle::make("actif")
                    ->label("Actif")
                ])->columns(2),

            ])->statePath("data");
    }

    public function create(): void
    {
        Inscription::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('inscription-created');

        Notification::make()
        ->title('Enregistrement effectué avec succès')
        ->success()
         ->duration(5000)
        ->send();
    }
}
