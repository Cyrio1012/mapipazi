<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doleance extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'contact',
        'sujet',
        'message',
        'status',
        'traiteur_id',
        'reponse',
        'traite_le',
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'traite_le' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur qui a traité la doléance.
     */
    public function traiteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'traiteur_id');
    }

    /**
     * Scope pour les doléances non traitées.
     */
    public function scopeNonTraitees($query)
    {
        return $query->whereIn('status', ['nouveau', 'en_cours']);
    }

    /**
     * Scope pour les doléances traitées.
     */
    public function scopeTraitees($query)
    {
        return $query->where('status', 'traite');
    }

    /**
     * Scope pour les doléances en cours.
     */
    public function scopeEnCours($query)
    {
        return $query->where('status', 'en_cours');
    }

    /**
     * Scope pour les doléances rejetées.
     */
    public function scopeRejetees($query)
    {
        return $query->where('status', 'rejete');
    }

    /**
     * Méthode pour marquer comme traité.
     */
    public function marquerCommeTraite($userId, $reponse = null)
    {
        $this->update([
            'status' => 'traite',
            'traiteur_id' => $userId,
            'reponse' => $reponse,
            'traite_le' => now(),
        ]);
    }

    /**
     * Méthode pour marquer comme en cours.
     */
    public function marquerEnCours($userId)
    {
        $this->update([
            'status' => 'en_cours',
            'traiteur_id' => $userId,
        ]);
    }

    /**
     * Méthode pour marquer comme rejeté.
     */
    public function marquerCommeRejete($userId, $raison = null)
    {
        $this->update([
            'status' => 'rejete',
            'traiteur_id' => $userId,
            'reponse' => $raison,
            'traite_le' => now(),
        ]);
    }

    /**
     * Accesseur pour le statut formaté.
     */
    public function getStatutFormateAttribute()
    {
        $statuts = [
            'nouveau' => ['badge' => 'badge-primary', 'text' => 'Nouveau'],
            'en_cours' => ['badge' => 'badge-warning', 'text' => 'En cours'],
            'traite' => ['badge' => 'badge-success', 'text' => 'Traité'],
            'rejete' => ['badge' => 'badge-danger', 'text' => 'Rejeté'],
        ];

        return $statuts[$this->status] ?? ['badge' => 'badge-secondary', 'text' => $this->status];
    }

    /**
     * Accesseur pour la date de création formatée.
     */
    public function getDateCreationAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * Accesseur pour la date de traitement formatée.
     */
    public function getDateTraitementAttribute()
    {
        return $this->traite_le ? $this->traite_le->format('d/m/Y H:i') : null;
    }
}