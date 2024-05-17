<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function Termwind\renderUsing;

class Date extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'from',
        'to',
    ];

    public $timestamps = false;

}
