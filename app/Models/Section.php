<?php

namespace App\Models;

use App\Models\Universite;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    protected $fillable=[
        "lib","universite_id","description",
    ];

    public function universite()
    {
        return $this->BelongsTo(Universite::class);
    }

    public function departements()
    {
        return $this->HasMany(Departement::class);
    }
}
