<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'treatment_id',
        'tooth_id',
        'type',
        'plan_number',
    ];

    public function patient(): BelongsTo {
        return $this->belongsTo(Patient::class);
    }

    public function treatment(): BelongsTo{
        return $this->belongsTo(Treatment::class);
    }

    public function tooth(): BelongsTo{
        return $this->belongsTo(Tooth::class);
    }

}
