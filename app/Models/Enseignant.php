<?php

namespace App\Models;

use App\Models\Cours;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Enseignant extends Model
{
    use HasFactory;
    protected $fillable=[
        "noms","fonction","tel","email","adresse","photo"
    ];


    public function cours()
    {
        return $this->BelongsToMany(Cours::class,"dispensers");
    }
}
