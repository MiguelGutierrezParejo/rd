<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tercero extends Model
{
    use HasFactory;
    
    protected $table = 'terceros';

    protected $casts = [
        'Fecha' => 'date:d-m-Y',
        'FechaPagado' => 'date:d-m-Y',
        'FechaEjecutiva' => 'date:d-m-Y',
        'FechaNotificacion' => 'date:d-m-Y',
        'FechaAnulacion' => 'date:d-m-Y',
    ];

    protected $fillable = ['Nombre', 'DNI', 'Expediente', 'Importe', 'Fecha', 'Texto', 'RD', 'Estado', 'Año', 'Total',
                           'FechaPagado', 'FechaEjecutiva', 'FechaNotificacion', 'Motivo', 'FechaAnulacion'];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'IdRd', 'RD');
    }
}
