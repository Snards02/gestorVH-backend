<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    // Opcional: lista de atributos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'plate',
        'type',
    ];

    /**
     * Relación uno a muchos: un vehículo tiene muchos documentos.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Relación uno a muchos: un vehículo tiene muchos registros de tanqueo.
     */
    public function fuelLogs()
    {
        return $this->hasMany(FuelLog::class);
    }
}
