<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Cours;

class Promotion extends Model
{
    use HasFactory;
    protected $fillable=[
        "lib","description",
    ];

    public function cours()
    {
        return $this->HasMany(Cours::class);
    }
}
