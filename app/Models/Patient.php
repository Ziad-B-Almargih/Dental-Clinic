<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'phone_number',
        'berth_date',
        'note',
        'prescription',
    ];

    /*
     * Relations
     */

    public function diseases(): BelongsToMany {
        return $this->belongsToMany(Disease::class);
    }

    public function operations(): HasMany {
        return $this->hasMany(Operation::class)
            ->orderBy('tooth_id')
            ->orderBy('created_at');
    }

    public function treatments(): HasMany {
        return $this->operations()
            ->where('type', '=', 'treatments');
    }

    public function diagnosis(): HasMany {
        return $this->operations()
            ->where('type', '=', 'diagnosis');
    }

    public function plan($number): HasMany {
        return $this->operations()
            ->where('type', '=', 'plans')
            ->where('plan_number', '=', $number);
    }

    public function payments(): HasMany {
        return $this->hasMany(Payment::class);
    }

    /*
     * Attributes
     */

    public function age(): Attribute {
        return Attribute::get(function (){
           return now()->year - Carbon::create($this['berth_date'])->year;
        });
    }

    public function totalCost(): Attribute {
        return Attribute::get(function (){
           return $this->treatments()->get()->sum('treatment.cost');
        });
    }

    public function totalPayments(): Attribute{
        return Attribute::get(function (){
            return $this->payments()->get()->sum('amount');
        });
    }

    public function remaining(): Attribute{
        return Attribute::get(function (){
            return $this['total_cost'] - $this['total_payments'];
        });
    }

    /*
     * Scopes
     */

    public function scopeSearch(Builder $q, $searchWord){
        return $q
            ->orderBy('updated_at')
            ->when($searchWord, function (Builder $q) use ($searchWord){
                return $q
                    ->where('name', 'LIKE', "%$searchWord%")
                    ->orWhere('phone_number', 'LIKE', "%$searchWord%");
            });
    }



}
