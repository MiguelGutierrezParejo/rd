<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $casts = [
        'Fecha' => 'date:d-m-Y',
    ];

    protected $fillable = ['IdRd', 'Fecha', 'Importe', 'Compensado', 'Texto'];

    public function tercero()
    {
        return $this->belongsTo(Tercero::class, 'IdRd');
    }
}
