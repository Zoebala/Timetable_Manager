<?php

namespace App\Filament\Resources\PromotionResource\Widgets;

use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Promotion;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class CreatePromotionWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.resources.promotion-resource.widgets.create-promotion-widget';

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
                Section::make("Définition des promotions")
                ->icon("heroicon-o-users")
                ->schema([
                    TextInput::make("lib")
                    ->label("Promotion")
                    ->live(debounce:900)
                    ->required()
                    ->placeholder("Ex: L1 math"),
                    MarkdownEditor::make("description")
                    ->disabled(fn(Get $get):bool => !filled($get("lib")))
                ]),
            ])->statePath("data");
    }
    public function create(): void
    {
        Promotion::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('promotion-created');
    }
}
