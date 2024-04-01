<?php

namespace App\Models;

use App\Models\Cours;
use App\Models\Salle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Programme extends Model
{
    use HasFactory;

    protected $fillable=[
        "cours_id","jours","debut","fin","salle_id",
    ];

    protected $casts=[
        "jours"=>'array',
    ];

    public function salle()
    {
        return $this->BelongsTo(Salle::class);
    }
    public function cours()
    {
        return $this->BelongsTo(Cours::class);
    }
}
