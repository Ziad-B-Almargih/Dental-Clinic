<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TreatmentClassification extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function treatments(): HasMany {
        return $this->hasMany(Treatment::class);
    }
}
