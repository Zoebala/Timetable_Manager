<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Universite extends Model
{
    use HasFactory;
    protected $fillable=[
        "lib","codepostal","ville","adresse","email","description",
    ];

    public function sections()
    {
        return $this->HasMany(Section::class);
    }

}
