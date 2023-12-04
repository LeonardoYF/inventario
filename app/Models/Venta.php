<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class venta extends Model
{
    use HasFactory;
    protected $table = 'venta';
    protected $primaryKey = 'id_venta';
    public $timestamps = true;
    protected $fillable = [
        'id_cliente',
        'tipo_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total_venta',
        'estatus'
    ];
}
