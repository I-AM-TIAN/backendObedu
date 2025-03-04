<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Autor extends Model
{
    //
    protected $table = 'autors';
    protected $fillable = ['primerNombre', 'segundoNombre', 'primerApellido', 'segundoApellido'];

    public function boletines(): BelongsToMany
    {
        return $this->belongsToMany(Boletin::class, 'autor_boletin', 'autor_id', 'boletin_id');
    }
}
