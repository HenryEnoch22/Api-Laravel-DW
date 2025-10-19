<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        // Relaciones
        'owner_id',

        // Identificación básica
        'name',
        'species',
        'breed',
        'sex',
        'size',
        'color',
        'birth_date',
        'weight_kg',
        'sterilized',

        // Documentos / medios
        'photo_path',

        // Operación de guardería
        'status',
        'admission_date',
        'last_visit_at',
    ];

    /**
     * Relación: una mascota pertenece a un dueño (usuario).
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
