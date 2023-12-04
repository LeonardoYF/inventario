<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'persona';
    protected $primaryKey = 'id_persona';
    public $timestamps = true;
    protected $fillable = [
        'tipo_persona',
        'nombre',
        'tipo_documento',
        'num_documento',
        'direccion	',
        'telefono',
        'email',
        'updated_at',
        'created_at'
    ];
    protected $guarded = [
        
    ];
}
