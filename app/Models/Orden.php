<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $fillable = [
        'numero_orden',
        'proveedor_id',
        'fecha_orden',
        'fecha_entrega',
        'total',
        'estado',
        'observaciones',
        'user_id'
    ];

    protected $casts = [
        'fecha_orden' => 'date',
        'fecha_entrega' => 'date',
    ];

    /**
     * Obtiene el proveedor de la orden
     */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Obtiene el usuario que creó la orden
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtiene los detalles de la orden
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleOrden::class);
    }
}
