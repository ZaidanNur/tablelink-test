<?php

namespace App\Models;

use App\Models\Builders\ApiFlightBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Flight extends Model
{
    protected $guarded = [];


    public function newEloquentBuilder($query)
    {
        return new ApiFlightBuilder($query);
    }

    public function getConnectionName()
    {
        return 'sqlite';
    }

    protected function priceFormatted(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => 
                'Rp ' . Number::format($attributes['price'] ?? 0, locale: 'id'),
        );
    }
}
