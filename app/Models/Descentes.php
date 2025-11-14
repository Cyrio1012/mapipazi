<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Descentes extends Model
{
    protected $fillable = [
        'date', 'heure', 'ref_om', 'ref_pv', 'ref_rapport', 'num_pv',
        'equipe', 'action', 'constat', 'pers_verb', 'qte_pers',
        'adresse', 'contact', 'dist', 'comm', 'fkt',
        'x', 'y','geom', 'date_rdv_ft', 'heure_rdv_ft', 'pieces_a_fournir','comparution'
    ];

    protected $casts = [
        'equipe' => 'array',
        'action' => 'array',
        'constat' => 'array',
        'pieces_a_fournir' => 'array',
        'date' => 'date',
        'heure' => 'datetime:H:i',
        'x' => 'float',
        'y' => 'float',
        'geom' => 'array',
    ];
}
