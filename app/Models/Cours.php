<?php

namespace App\Models;

use App\Models\Promotion;
use App\Models\Enseignant;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cours extends Model
{
    use HasFactory;
    protected $fillable=[
        "lib","credit","description","promotion_id","departement_id",
    ];


    public function enseignants()
    {
        return $this->BelongsToMany(Enseignant::class,"dispensers");
    }

    public function promotion()
    {
        return $this->BelongsTo(Promotion::class);
    }

    public function departement()
    {
        return $this->BelongsTo(Departement::class);
    }
}
