<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matro extends Model
{
    //
    protected $fillable = [
        'id_descent', 'designation', 'marque', 'type', 'imm', 'volume'
    ];
}
