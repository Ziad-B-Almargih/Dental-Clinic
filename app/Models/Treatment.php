<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'treatment_classification_id',
        'cost',
    ];

    public $timestamps = false;

    public function scopeFilter($query,array $filters){
        return $query
            ->when($filters['search_word'], function (Builder $q) use ($filters){
                return $q
                     ->where('name', 'LIKE', '%'.$filters['search_word'].'%');
            })
            ->when($filters['classification_id'], function (Builder $q) use ($filters){
                return $q
                    ->where('treatment_classification_id', $filters['classification_id']);
            });
    }
}
