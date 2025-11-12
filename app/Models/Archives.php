<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Archives extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'archives';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'exoyear',
        'arrivaldate',
        'arrivalid',
        'sendersce',
        'descentdate',
        'reportid',
        'summondate',
        'actiontaken',
        'measures',
        'findingof',
        'applicantname',
        'applicantaddress',
        'applicantcontact',
        'locality',
        'municipality',
        'property0wner',
        'propertytitle',
        'propertyname',
        'urbanplanningregulations',
        'upr',
        'zoning',
        'surfacearea',
        'backfilledarea',
        'xv',
        'yv',
        'minutesid',
        'minutesdate',
        'partsupplied',
        'submissiondate',
        'destination',
        'svr_fine',
        'svr_roalty',
        'invoicingid',
        'invoicingdate',
        'fineamount',
        'roaltyamount',
        'convention',
        'payementmethod',
        'daftransmissiondate',
        'ref_quitus',
        'sit_r',
        'sit_a',
        'commissiondate',
        'commissionopinion',
        'recommandationobs',
        'opfinal',
        'opiniondfdate',
        'category'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'exoyear' => 'string',
        'arrivaldate' => 'date',
        'descentdate' => 'date',
        'summondate' => 'date',
        'minutesdate' => 'date',
        'submissiondate' => 'date',
        'invoicingdate' => 'date',
        'daftransmissiondate' => 'date',
        'commissiondate' => 'date',
        'opiniondfdate' => 'date',
        'surfacearea' => 'decimal:2',
        'backfilledarea' => 'decimal:2',
        'xv' => 'decimal:10,6',
        'yv' => 'decimal:10,6',
        'svr_fine' => 'decimal:2',
        'svr_roalty' => 'decimal:2',
        'fineamount' => 'decimal:2',
        'roaltyamount' => 'decimal:2',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'arrivaldate',
        'descentdate',
        'summondate',
        'minutesdate',
        'submissiondate',
        'invoicingdate',
        'daftransmissiondate',
        'commissiondate',
        'opiniondfdate',
        'created_at',
        'updated_at'
    ];

    /**
     * Accessors for numeric values
     */
    public function getSurfaceareaAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    public function getBackfilledareaAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    public function getXvAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    public function getYvAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    public function getSvrFineAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    public function getSvrRoatlyAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    public function getFineamountAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    public function getRoatlyamountAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    /**
     * Accessors for formatted display
     */
    public function getFormattedArrivaldateAttribute()
    {
        return $this->arrivaldate ? $this->arrivaldate->format('d/m/Y') : null;
    }

    public function getFormattedDescentdateAttribute()
    {
        return $this->descentdate ? $this->descentdate->format('d/m/Y') : null;
    }

    public function getFormattedSummondateAttribute()
    {
        return $this->summondate ? $this->summondate->format('d/m/Y') : null;
    }

    public function getFormattedSurfaceareaAttribute()
    {
        return $this->surfacearea ? number_format($this->surfacearea, 2, ',', ' ') : null;
    }

    public function getFormattedFineamountAttribute()
    {
        return $this->fineamount ? number_format($this->fineamount, 2, ',', ' ') : null;
    }

    public function getFormattedRoatlyamountAttribute()
    {
        return $this->roaltyamount ? number_format($this->roaltyamount, 2, ',', ' ') : null;
    }

    /**
     * Mutators for data formatting before save
     */
    public function setExoyearAttribute($value)
    {
        $this->attributes['exoyear'] = $value ? strtoupper(substr($value, 0, 10)) : null;
    }

    public function setApplicantnameAttribute($value)
    {
        $this->attributes['applicantname'] = $value ? substr($value, 0, 250) : null;
    }

    public function setApplicantaddressAttribute($value)
    {
        $this->attributes['applicantaddress'] = $value ? substr($value, 0, 250) : null;
    }

    public function setApplicantcontactAttribute($value)
    {
        $this->attributes['applicantcontact'] = $value ? substr($value, 0, 250) : null;
    }

    public function setSendersceAttribute($value)
    {
        $this->attributes['sendersce'] = $value ? substr($value, 0, 250) : null;
    }

    public function setActiontakenAttribute($value)
    {
        $this->attributes['actiontaken'] = $value ? substr($value, 0, 500) : null;
    }

    public function setFindingofAttribute($value)
    {
        $this->attributes['findingof'] = $value ? substr($value, 0, 72) : null;
    }

    /**
     * Scopes for common queries
     */
    public function scopeWithValidCoordinates($query)
    {
        return $query->whereNotNull('xv')
                    ->whereNotNull('yv')
                    ->where('xv', '!=', 0)
                    ->where('yv', '!=', 0);
    }

    public function scopeWithoutCoordinates($query)
    {
        return $query->where(function($q) {
            $q->whereNull('xv')
              ->orWhereNull('yv')
              ->orWhere('xv', 0)
              ->orWhere('yv', 0);
        });
    }

    public function scopeForYear($query, $year)
    {
        return $query->where('exoyear', $year);
    }

    public function scopeForMunicipality($query, $municipality)
    {
        return $query->where('municipality', $municipality);
    }

    public function scopeForLocality($query, $locality)
    {
        return $query->where('locality', $locality);
    }

    public function scopeWithFine($query)
    {
        return $query->where('fineamount', '>', 0);
    }

    public function scopeWithRoyalty($query)
    {
        return $query->where('roaltyamount', '>', 0);
    }

    public function scopeWithFinancialData($query)
    {
        return $query->where(function($q) {
            $q->where('fineamount', '>', 0)
              ->orWhere('roaltyamount', '>', 0);
        });
    }

    public function scopePendingPayment($query)
    {
        return $query->where(function($q) {
            $q->where('fineamount', '>', 0)
              ->orWhere('roaltyamount', '>', 0);
        })->where(function($q) {
            $q->whereNull('invoicingdate')
              ->orWhere('invoicingdate', '');
        });
    }

    public function scopeWithCommissionOpinion($query, $opinion)
    {
        return $query->where('commissionopinion', $opinion);
    }

    public function scopeWithFinalOpinion($query, $opinion)
    {
        return $query->where('opfinal', $opinion);
    }

    /**
     * Utility methods
     */
    public function hasCoordinates(): bool
    {
        return !empty($this->xv) && !empty($this->yv) && $this->xv != 0 && $this->yv != 0;
    }

    public function hasFinancialData(): bool
    {
        return !empty($this->fineamount) || !empty($this->roaltyamount);
    }

    public function hasPaid(): bool
    {
        return !empty($this->invoicingdate);
    }

    public function getTotalAmount(): float
    {
        return ($this->fineamount ?? 0) + ($this->roaltyamount ?? 0);
    }

    public function getFormattedTotalAmount(): string
    {
        return number_format($this->getTotalAmount(), 2, ',', ' ');
    }

    public function getCoordinates(): ?array
    {
        if (!$this->hasCoordinates()) {
            return null;
        }

        return [
            'x' => $this->xv,
            'y' => $this->yv
        ];
    }

    public function getStatus(): string
    {
        if ($this->opfinal) {
            return 'Finalisé - ' . $this->opfinal;
        }

        if ($this->commissionopinion) {
            return 'En commission - ' . $this->commissionopinion;
        }

        if ($this->hasPaid()) {
            return 'Paiement effectué';
        }

        if ($this->hasFinancialData()) {
            return 'En attente de paiement';
        }

        return 'En traitement';
    }

    /**
     * Date-related methods
     */
    public function getProcessingTime(): ?int
    {
        if (!$this->arrivaldate || !$this->opiniondfdate) {
            return null;
        }

        return $this->arrivaldate->diffInDays($this->opiniondfdate);
    }

    public function isOverdue(): bool
    {
        if (!$this->arrivaldate) {
            return false;
        }

        $processingTime = $this->getProcessingTime();
        return $processingTime !== null && $processingTime > 30; // Supposons 30 jours comme délai normal
    }

    /**
     * Search scope
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('applicantname', 'ILIKE', "%{$search}%")
              ->orWhere('arrivalid', 'ILIKE', "%{$search}%")
              ->orWhere('reportid', 'ILIKE', "%{$search}%")
              ->orWhere('minutesid', 'ILIKE', "%{$search}%")
              ->orWhere('invoicingid', 'ILIKE', "%{$search}%")
              ->orWhere('locality', 'ILIKE', "%{$search}%")
              ->orWhere('municipality', 'ILIKE', "%{$search}%");
        });
    }

   
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('arrivaldate', 'desc')
                    ->orderBy('id', 'desc');
    }

    public function scopeOldestFirst($query)
    {
        return $query->orderBy('arrivaldate', 'asc')
                    ->orderBy('id', 'asc');
    }
}