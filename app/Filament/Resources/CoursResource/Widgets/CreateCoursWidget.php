<?php

namespace App\Filament\Resources\CoursResource\Widgets;

use App\Models\Cours;
use Filament\Forms\Form;
use App\Models\Promotion;
use App\Models\Departement;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateCoursWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.resources.cours-resource.widgets.create-cours-widget';

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
                Wizard::make([
                    Step::make("Informations Cours")
                    ->schema([
                        Section::make("")
                        ->collapsible()
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
            ])->statePath("data");
    }

    public function create(): void
    {
        Cours::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('cours-created');

        Notification::make()
        ->title('Enregistrement effectué avec succès')
        ->success()
         ->duration(5000)
        ->send();
    }

}
