<?php

namespace App\Models;

use App\Models\Cours;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Departement extends Model
{
    use HasFactory;
    protected $fillable=[
        "lib","section_id","description",
    ];

    public function section()
    {
        return $this->BelongsTo(Section::class);
    }

    public function cours()
    {
        return $this->HasMany(Cours::class);
    }
}
