<?php

namespace App\Models;

use App\Models\Etudiant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Abonnement extends Model
{
    use HasFactory;

    protected $fillable=[
        "actif","etudiant_id",
    ];

    public function etudiant()
    {
        return $this->BelongsTo(Etudiant::class);
    }
}
