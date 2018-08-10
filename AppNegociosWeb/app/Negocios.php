<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Negocios extends Model
{
    protected $table='tbNegocios';
    protected $primaryKey = 'IdNegocio';
   
   protected $fillable = [
                'Imagen1',
                'Imagen2',
                'Imagen3',
                'IdUsuario',
                'Nombre_Negocio',
                'Descripcion',
                'Direccion_N',
                'Horario',
                'Telefono_F',
                'Telefono_M',
                'Email_N',
                'Sitio_Web',
                'Facebook',
                'Instagram',
                'Twitter',
                'Otra_Red',
                'Posicion_GPS',
                'Tags',
                'Fech_Ini_Suscrip',
                'Fech_Fin_Suscrip',
                'IdCategoria',
                'bitStatus',
            ];
    
   public function Negocios(){
    return $this->belongsTo('App/Negocios');
   }
}
