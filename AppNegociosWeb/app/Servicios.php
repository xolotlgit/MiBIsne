<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
   protected $table='tbservicios';
   protected $primaryKey = 'IdServicio';
   
   protected $fillable = ['IdNegocio','Nombre_Servicio', 'Descripcion_S', 'Costo'];
   
   public function servicio(){
        return $this->hasMany('App/Servicios');
    }
}
