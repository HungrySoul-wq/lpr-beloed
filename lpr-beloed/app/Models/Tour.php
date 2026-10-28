<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'title',
        'start_date',
        'days',
        'price',
        'is_hot',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'days' => 'integer',
            'price' => 'decimal:2',
            'is_hot' => 'boolean',
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function extras(): BelongsToMany
    {
        return $this->belongsToMany(Extra::class);
    }
}