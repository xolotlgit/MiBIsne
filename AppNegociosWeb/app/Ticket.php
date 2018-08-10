<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table='tbtickets';
    protected $primaryKey = 'IdTicket';
   
   protected $fillable = ['IdUsuario','ValorTicket', 'FechaAdquisicion'];
}


