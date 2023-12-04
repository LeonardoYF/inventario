<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    protected $table = 'detalle_venta';
    protected $primaryKey = 'id_detalle_venta';
    public $timestamps = true;
    protected $fillable = [
        'id_venta',
        'id_producto',
        'cantidad',
        'descuento',
        'precio_venta'
    ];
    protected $guarded = [
        
    ];
    
}
