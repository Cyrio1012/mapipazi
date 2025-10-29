<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Propriete extends Model
{
    protected $fillable = [
        'id_descent', 'x', 'y', 'titre', 'plle', 'imm',
        'superficie', 'sup_remblais', 'comm_desc', 'pu',
        'zone', 'destination','proprietaire'
    ];

    protected $casts = [
        'x' => 'float',
        'y' => 'float',
    ];

    public function descente()
    {
        return $this->belongsTo(\App\Models\Descentes::class, 'id_descent');
    }
}
