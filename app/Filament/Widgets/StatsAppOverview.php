<?php

namespace App\Filament\Widgets;

use App\Models\Annee;
use App\Models\Salle;
use App\Models\Section;
use App\Models\Etudiant;
use App\Models\Programme;
use App\Models\Promotion;
use App\Models\Universite;
use App\Models\Departement;
use App\Models\Inscription;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsAppOverview extends BaseWidget
{
    // protected static ?int $sort=2;
    protected function getStats(): array
    {
        return [
            Stat::make('Annees Académique', Annee::query()->count())
                ->description('Année de chaque institution/université')
                ->Icon('heroicon-m-calendar-days')
                ->color('success'),
                Stat::make('Universités/Institutions',Universite::query()->count())
                ->description('Toutes les institutions et universités')
                ->Icon('heroicon-o-building-office-2')
                ->color('warning'),
                Stat::make('Sections', Section::query()->count())
                ->description('Toutes les sections')
                ->Icon('heroicon-o-building-office-2')
                ->color('success'),
                // Stat::make('Departements', Departement::query()->count())
                // ->description('Tous les departements')
                // ->Icon('heroicon-o-building-office-2')
                // ->color('warning'),
                // Stat::make('Promotions', Promotion::query()->count())
                // ->description('Toutes les promotions')
                // ->Icon('heroicon-o-users')
                // ->color('success'),
                // Stat::make('Etudiants', Etudiant::query()->count())
                // ->description('Tous les étudiants')
                // ->Icon('heroicon-o-users')
                // ->color('warning'),
                Stat::make('Inscriptions', Inscription::query()->count())
                ->description('Toutes les inscriptions')
                ->Icon('heroicon-o-clipboard-document-list')
                ->color('warning'),
                Stat::make('Salle', Salle::query()->count())
                ->description('Toutes les salles')
                ->Icon('heroicon-o-home')
                ->color('success'),
                Stat::make('Programmes', Programme::query()->count())
                ->description('Tous les programmes')
                ->Icon('heroicon-o-clipboard-document-list')
                ->color('warning'),
        ];
    }
}
