<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Boletin extends Model
{
    protected $table = 'boletines';
    protected $fillable = ['titulo', 'contenido', 'descripcion','imagen', 'fecha', 'pdf', 'categoria_id', 'tipo_id'];

    // Relación con autores (muchos a muchos)
    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(Autor::class, 'autor_boletin', 'boletin_id', 'autor_id');
    }

    // Relación con párrafos (uno a muchos)
    public function parrafos(): HasMany
    {
        return $this->hasMany(Parrafo::class);
    }

    //Relacion con el tipo
    public function tipo(): BelongsTo{
        return $this->belongsTo(Tipo::class);
    }

    //Relacion con la categoria
    public function categoria(): BelongsTo{
        return $this->belongsTo(Categoria::class);
    }
}
