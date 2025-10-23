<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ap extends Model
{
     protected $fillable = [
        'id_descent', 'num_ap', 'type', 'date_ap', 'sup_remblais',
        'comm_propriete', 'pu', 'zone', 'destination', 'taux', 'situation'
    ];

    protected $casts = [
        'date_ap' => 'date',
        'sup_remblais' => 'float',
        'taux' => 'float',
    ];

    public function descente()
    {
        return $this->belongsTo(\App\Models\Descentes::class, 'id_descent');
    }
}
