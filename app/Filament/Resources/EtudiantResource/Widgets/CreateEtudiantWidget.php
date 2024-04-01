<?php

namespace App\Filament\Resources\EtudiantResource\Widgets;

use App\Models\Etudiant;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateEtudiantWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.resources.etudiant-resource.widgets.create-etudiant-widget';

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
                Section::make("Identification de l'étudiant")
                ->icon("heroicon-o-user-plus")
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
            ])->columns(3)->statePath("data");

    }

    public function create(): void
    {
        Etudiant::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('etudiant-created');

        Notification::make()
        ->title('Enregistrement effectué avec succès')
        ->success()
         ->duration(5000)
        ->send();
    }
}
