<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ft extends Model
{
    protected $fillable = [
        'id_descent',
        'date', 'heure',
        'num_ft', 'antony_ft',
        'constat_desc', 'dist_desc', 'comm_desc', 'fkt_desc', 'pu',
        'zone', 'destination',
        'x_desc', 'y_desc',
        'objet_ft',
        'nom_pers_venue', 'qte_pers_venue', 'contact', 'adresse', 'cin',
        'pieces_apporter', 'recommandation', 'pieces_complement',
        'delais', 'date_rdv_ft', 'heure_rdv_ft'
    ];

    protected $casts = [
        'date' => 'datetime',
        'heure' => 'datetime:H:i',
        'date_rdv_ft' => 'datetime',
        'heure_rdv_ft' => 'datetime:H:i',

        'x_desc' => 'float',
        'y_desc' => 'float',

        'constat_desc' => 'array',
        'pieces_apporter' => 'array',
        'pieces_complement' => 'array',
    ];

    public function descente()
    {
        return $this->belongsTo(\App\Models\Descentes::class, 'id_descente');
    }
}
