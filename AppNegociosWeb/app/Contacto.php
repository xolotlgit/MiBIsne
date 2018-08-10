<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = 'tbcontactos';
    protected $primaryKey = 'IdContacto';
    
    protected $fillable = ['Nombre', 'Correo', 'Telefono1','Telefono2', 'Direccion_Url'];

     protected $hidden = [
        'IdContacto',
    ];
}
