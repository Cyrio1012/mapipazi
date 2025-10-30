<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descente extends Model
{
    use HasFactory;

    protected $table = 'descentes';

    protected $fillable = [
        'date',
        'heure',
        'ref_om',
        'ref_pv',
        'ref_rapport',
        'num_pv',
        'equipe',
        'action',
        'constat',
        'pers_verb',
        'qte_pers',
        'adresse',
        'contact',
        'dist',
        'comm',
        'fkt',
        'x',
        'y'
    ];

    protected $casts = [
        'date' => 'date',
        'equipe' => 'array',
        'action' => 'array',
        'constat' => 'array',
        'x' => 'integer',
        'y' => 'integer',
        'pers_verb' => 'integer',
        'qte_pers' => 'integer'
    ];

    /**
     * Accesseur pour les coordonnées formatées
     */
    public function getCoordinatesAttribute()
    {
        return [
            'x' => floatval($this->x),
            'y' => floatval($this->y)
        ];
    }

    /**
     * Accesseur pour l'équipe formatée
     */
    public function getEquipeFormateeAttribute()
    {
        return $this->formatArrayField($this->equipe);
    }

    /**
     * Accesseur pour l'action formatée
     */
    public function getActionFormateeAttribute()
    {
        return $this->formatArrayField($this->action);
    }

    /**
     * Accesseur pour le constat formaté
     */
    public function getConstatFormateeAttribute()
    {
        return $this->formatArrayField($this->constat);
    }

    /**
     * Formater les champs de type array
     */
    private function formatArrayField($field)
    {
        if (is_array($field)) {
            return implode(', ', $field);
        }
        
        if (is_string($field)) {
            try {
                $decoded = json_decode($field, true);
                if (is_array($decoded)) {
                    return implode(', ', $decoded);
                }
            } catch (\Exception $e) {
                // Si le décodage échoue, retourner la chaîne originale
            }
        }
        
        return $field ?? 'Non spécifié';
    }

    /**
     * Scope pour les descentes avec coordonnées valides
     */
    public function scopeAvecCoordonneesValides($query)
    {
        return $query->whereNotNull('x')
                    ->whereNotNull('y')
                    ->where('x', '!=', 0)
                    ->where('y', '!=', 0);
    }

    /**
     * Scope pour rechercher par référence
     */
    public function scopeParReference($query, $reference)
    {
        return $query->where('ref_om', 'LIKE', "%{$reference}%")
                    ->orWhere('ref_pv', 'LIKE', "%{$reference}%")
                    ->orWhere('num_pv', 'LIKE', "%{$reference}%");
    }

    /**
     * Scope pour rechercher par localisation
     */
    public function scopeParLocalisation($query, $localisation)
    {
        return $query->where('adresse', 'LIKE', "%{$localisation}%")
                    ->orWhere('comm', 'LIKE', "%{$localisation}%")
                    ->orWhere('dist', 'LIKE', "%{$localisation}%")
                    ->orWhere('fkt', 'LIKE', "%{$localisation}%");
    }
}