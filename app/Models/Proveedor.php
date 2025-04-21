<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'nit',
        'direccion',
        'telefono',
        'email',
        'persona_contacto',
        'activo'
    ];

    /**
     * Obtiene los productos asociados a este proveedor
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    /**
     * Obtiene las órdenes asociadas a este proveedor
     */
    public function ordenes(): HasMany
    {
        return $this->hasMany(Orden::class);
    }
}
