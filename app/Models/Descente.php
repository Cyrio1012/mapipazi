<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descente extends Model
{
    use HasFactory;

    protected $table = 'descentes';

    // Toutes les colonnes de la table dans fillable
    protected $fillable = [
        'id',
        'date',
        'heure',
        'ref_om',
        'ref_pv',
        'ref_rapport',
        'num_pv',
        'ft_id',
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
        'y',
        'geom',
        'date_rdv_ft',
        'heure_rdv_ft',
        'pieces_a_fournir',
        'pieces_fournis',
        'created_at',
        'updated_at'
    ];

    // Casts mis à jour pour toutes les colonnes
    protected $casts = [
        'date' => 'date',
        'heure' => 'string', // time without time zone
        'ref_om' => 'string',
        'ref_pv' => 'string',
        'ref_rapport' => 'string',
        'num_pv' => 'string',
        'ft_id' => 'string',
        'equipe' => 'array',
        'action' => 'array',
        'constat' => 'array',
        'pers_verb' => 'string',
        'qte_pers' => 'string',
        'adresse' => 'string',
        'contact' => 'string',
        'dist' => 'string',
        'comm' => 'string',
        'fkt' => 'string',
        'x' => 'double',
        'y' => 'double',
        'geom' => 'array',
        'date_rdv_ft' => 'date',
        'heure_rdv_ft' => 'string', // time without time zone
        'pieces_a_fournir' => 'array',
        'pieces_fournis' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Ajouter les accesseurs aux propriétés JSON
    protected $appends = [
        'coordinates',
        'equipe_formatee',
        'action_formatee',
        'constat_formatee',
        'pieces_a_fournir_formatee',
        'pieces_fournis_formatee',
        'geometrie_formatee'
    ];

    /**
     * Accesseur pour les coordonnées formatées
     */
    public function getCoordinatesAttribute()
    {
        return [
            'x' => $this->x !== null ? floatval($this->x) : null,
            'y' => $this->y !== null ? floatval($this->y) : null
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
     * Accesseur pour les pièces à fournir formatées
     */
    public function getPiecesAFournirFormateeAttribute()
    {
        return $this->formatArrayField($this->pieces_a_fournir);
    }

    /**
     * Accesseur pour les pièces fournies formatées
     */
    public function getPiecesFournisFormateeAttribute()
    {
        return $this->formatArrayField($this->pieces_fournis);
    }

    /**
     * Accesseur pour la géométrie formatée
     */
    public function getGeometrieFormateeAttribute()
    {
        return $this->formatArrayField($this->geom);
    }

    /**
     * Accesseur pour la date et heure complète de descente
     */
    public function getDateTimeCompleteAttribute()
    {
        return $this->date?->format('d/m/Y') . ($this->heure ? ' ' . $this->heure : '');
    }

    /**
     * Accesseur pour la date et heure complète du RDV FT
     */
    public function getDateTimeRdvFtCompleteAttribute()
    {
        return $this->date_rdv_ft?->format('d/m/Y') . ($this->heure_rdv_ft ? ' ' . $this->heure_rdv_ft : '');
    }

    /**
     * Formater les champs de type array
     */
    private function formatArrayField($field)
    {
        if (is_array($field)) {
            return implode(', ', array_filter($field));
        }
        
        if (is_string($field)) {
            try {
                $decoded = json_decode($field, true);
                if (is_array($decoded)) {
                    return implode(', ', array_filter($decoded));
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
     * Scope pour les descentes avec géométrie
     */
    public function scopeAvecGeometrie($query)
    {
        return $query->whereNotNull('geom')
                    ->where('geom', '!=', '[]');
    }

    /**
     * Scope pour les descentes avec RDV FT
     */
    public function scopeAvecRdvFt($query)
    {
        return $query->whereNotNull('date_rdv_ft')
                    ->whereNotNull('heure_rdv_ft');
    }

    /**
     * Scope pour rechercher par référence
     */
    public function scopeParReference($query, $reference)
    {
        return $query->where('ref_om', 'ILIKE', "%{$reference}%")
                    ->orWhere('ref_pv', 'ILIKE', "%{$reference}%")
                    ->orWhere('ref_rapport', 'ILIKE', "%{$reference}%")
                    ->orWhere('num_pv', 'ILIKE', "%{$reference}%")
                    ->orWhere('ft_id', 'ILIKE', "%{$reference}%");
    }

    /**
     * Scope pour rechercher par localisation
     */
    public function scopeParLocalisation($query, $localisation)
    {
        return $query->where('adresse', 'ILIKE', "%{$localisation}%")
                    ->orWhere('comm', 'ILIKE', "%{$localisation}%")
                    ->orWhere('dist', 'ILIKE', "%{$localisation}%")
                    ->orWhere('fkt', 'ILIKE', "%{$localisation}%");
    }

    /**
     * Scope pour rechercher par période
     */
    public function scopeParPeriode($query, $debut, $fin = null)
    {
        if ($fin === null) {
            return $query->whereDate('date', $debut);
        }
        
        return $query->whereBetween('date', [$debut, $fin]);
    }

    /**
     * Scope pour rechercher par contact
     */
    public function scopeParContact($query, $contact)
    {
        return $query->where('contact', 'ILIKE', "%{$contact}%");
    }

    /**
     * Recherche globale sur tous les champs textuels
     */
    public function scopeRechercheGlobale($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('ref_om', 'ILIKE', "%{$term}%")
              ->orWhere('ref_pv', 'ILIKE', "%{$term}%")
              ->orWhere('ref_rapport', 'ILIKE', "%{$term}%")
              ->orWhere('num_pv', 'ILIKE', "%{$term}%")
              ->orWhere('ft_id', 'ILIKE', "%{$term}%")
              ->orWhere('adresse', 'ILIKE', "%{$term}%")
              ->orWhere('contact', 'ILIKE', "%{$term}%")
              ->orWhere('dist', 'ILIKE', "%{$term}%")
              ->orWhere('comm', 'ILIKE', "%{$term}%")
              ->orWhere('fkt', 'ILIKE', "%{$term}%")
              ->orWhere('pers_verb', 'ILIKE', "%{$term}%")
              ->orWhere('qte_pers', 'ILIKE', "%{$term}%");
        });
    }
}