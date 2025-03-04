<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    //
    protected $table = 'tipos';
    protected $fillable = ['nombre', 'descripcion'];

    public function boletines(){
        return $this->hasMany(Boletin::class);
    }
}
