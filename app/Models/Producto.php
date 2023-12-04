<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    public $timestamps = true;
    protected $fillable = [
        'id_categoria',
        'codigo',
        'nombre',
        'stock',
        'descripcion',
        'imagen',
        'status',
        'updated_at',
        'created_at'
    ];
    protected $guarded = [
        
    ];
}
