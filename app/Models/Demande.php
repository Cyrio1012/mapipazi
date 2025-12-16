<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'demandes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'xv',
        'yv',
        'upr',
        'sit_r',
        'exoyear',
        'opfinal',
        'category',
        'locality',
        'arrivalid',
        'sendersce',
        'arrivaldate',
        'invoicingid',
        'surfacearea',
        'municipality',
        'propertyname',
        'roaltyamount',
        'applicantname',
        'invoicingdate',
        'opiniondfdate',
        'propertyowner', // Note: j'ai corrigé property0wner en propertyowner
        'propertytitle',
        'backfilledarea',
        'commissiondate',
        'applicantaddress',
        'commissionopinion',
        'urbanplanningregulations',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'arrivaldate' => 'date',
        'invoicingdate' => 'date',
        'opiniondfdate' => 'date',
        'commissiondate' => 'date',
        'surfacearea' => 'decimal:2',
        'roaltyamount' => 'decimal:2',
        'backfilledarea' => 'decimal:2',
    ];
}
