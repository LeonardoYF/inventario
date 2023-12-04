<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categoria';
    protected $primaryKey = 'id_categoria';
    public $timestamps = true;
    protected $fillable = [
        'categoria',
        'descripcion',
        'status',
        'updated_at',
        'created_at'
    ];
    protected $guarded = [
        
    ];
}
