<?php

namespace App\Models;

use App\Models\Annee;
use App\Models\Etudiant;
use App\Models\Promotion;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable=[
        "departement_id","promotion_id","etudiant_id","annee_id","actif"
    ];

    public function departement()
    {
        return $this->BelongsTo(Departement::class);
    }
    public function promotion()
    {
        return $this->BelongsTo(Promotion::class);
    }

    public function etudiant()
    {
        return $this->BelongsTo(Etudiant::class);

    }
    public function annee()
    {
        return $this->BelongsTo(Annee::class);
    }
}
