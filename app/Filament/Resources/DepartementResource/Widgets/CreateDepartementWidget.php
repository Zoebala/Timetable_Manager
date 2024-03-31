<?php

namespace App\Filament\Resources\DepartementResource\Widgets;

use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Departement;
use Filament\Widgets\Widget;
use App\Models\Section as Sections;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateDepartementWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.resources.departement-resource.widgets.create-departement-widget';
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
            ])->statePath("data");
    }

    public function create(): void
    {
        Departement::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('departement-created');
    }
}
