<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleOrden extends Model
{
    use HasFactory;

    protected $table = 'detalle_ordenes';

    protected $fillable = [
        'orden_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    /**
     * Obtiene la orden a la que pertenece este detalle
     */
    public function orden(): BelongsTo
    {
        return $this->belongsTo(Orden::class);
    }

    /**
     * Obtiene el producto del detalle
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}
