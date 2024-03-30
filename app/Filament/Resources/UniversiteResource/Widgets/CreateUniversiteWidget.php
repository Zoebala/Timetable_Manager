<?php

namespace App\Filament\Resources\UniversiteResource\Widgets;

use Filament\Forms\Form;
use App\Models\Universite;
use Filament\Widgets\Widget;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;

use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;

use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateUniversiteWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    protected static string $view = 'filament.resources.universite-resource.widgets.create-universite-widget';
    protected int | string | array $columnSpan = 'full';

    public function mount(): void
    {
        $this->form->fill();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([
                    Step::make('Informations')
                    ->schema([
                        // ...
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
                            ->placeholder("Ex: universite@example.com")
                            ->columnspan(2),
                            ])->columns(2)->columnspan(2),
                         Section::make()
                        ->icon("heroicon-o-camera")
                        ->description("Profile de votre Institution")
                        ->schema([
                                FileUpload::make("photo")
                                ->disk("public")->directory("photos")
                            ])->columnspan(1),
                    ])->columns(3),
                    Step::make("Description")
                    ->schema([

                        MarkdownEditor::make("description")
                        ->columnSpanfull()
                    ])
                ])->columnSpanFull()->columns(2),
            ])->columns(3)
            ->statePath('data');
    }

    public function create(): void
    {
        Universite::create($this->form->getState());
        $this->form->fill();
        $this->dispatch('universite-created');
    }
}
