<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ap extends Model
{
    protected $fillable = [
        'id_descent',
        'num_ap',
        'nom_proprietaire',
        'type',
        'date_ap',
        'sup_remblais',
        'comm_propriete',
        'x',
        'y',
        'fkt',
        'zone',
        'titre',
        'destination',
        'taux',
        'taux_payer',
        'notifier',
        'delais_md',
        'situation'    
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
