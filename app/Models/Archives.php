<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archives extends Model
{
    use HasFactory;

    protected $table = 'archive';
    
    protected $fillable = [
        'geom', 'date_arriv', 'ref_arriv', 'sce_envoyeur', 'action', 
        'ref_pvPat1', 'date_pvPat1', 'ref_pvPat2', 'date_pvPat2', 
        'ref_nonResp', 'date_nonR', 'date_desc', 'constat', 'respo_dmd', 
        'adresse', 'contact', 'fkt', 'commune', 'proprio', 'titre_plle', 
        'plle', 'imm_terrain', 'cat_zone', 'pu_zoning', 'zoning', 
        'area_m', 'area_need', 'COS', 'nota_terrain', 'Xv', 'Yv', 
        'ref_FT', 'date_FT', 'pces_fournies', 'date_dépot', 'destination', 
        'tvu_a', 'tvu_r', 'ref_AP', 'date_AP', 'val_a', 'val_r', 
        'Convention', 'mod_paie', 'date_transmDAF', 'ref_quitce', 
        'situ_r', 'situ_a', 'date_coms', 'delib_coms', 'obs_recmd', 
        'avis_def', 'date_def', 'cat_situ'
    ];

    protected $casts = [
        'date_arriv' => 'date',
        'date_pvPat1' => 'date',
        'date_pvPat2' => 'date',
        'date_nonR' => 'date',
        'date_desc' => 'date',
        'date_FT' => 'date',
        'date_dépot' => 'date',
        'date_AP' => 'date',
        'date_transmDAF' => 'date',
        'date_coms' => 'date',
        'date_def' => 'date',
        // AJOUT: Cast pour les coordonnées maintenant en double precision
        'Xv' => 'double',
        'Yv' => 'double',
    ];

    // Optionnel: Accessors pour s'assurer du type (recommandé)
    public function getXvAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    public function getYvAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    // Scope pour les archives avec coordonnées valides
    public function scopeWithValidCoordinates($query)
    {
        return $query->whereNotNull('Xv')
                    ->whereNotNull('Yv')
                    ->where('Xv', '!=', 0)
                    ->where('Yv', '!=', 0);
    }

    // Scope pour les archives sans coordonnées
    public function scopeWithoutCoordinates($query)
    {
        return $query->whereNull('Xv')
                    ->orWhereNull('Yv')
                    ->orWhere('Xv', 0)
                    ->orWhere('Yv', 0);
    }
}