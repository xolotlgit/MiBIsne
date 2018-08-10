<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'tbcategorias';
    protected $primaryKey = 'IdCategoria';
    
    protected $fillable = ['NombreCategoria', 'Descripcion'];

}
