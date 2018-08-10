<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    protected $table = 'tbanuncios';
    protected $primaryKey = 'IdAnuncio';

    protected $fillable = ['IdNegocio','Nombre_Anuncio', 'Fecha_Inicio','Fecha_Fin','Imagen_Url','bitStatus'];
    
}
