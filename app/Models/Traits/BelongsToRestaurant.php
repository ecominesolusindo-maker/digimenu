<?php

namespace App\Models\Traits;

use App\Models\Restaurant;
use App\Models\Scopes\RestaurantScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToRestaurant
{
    /**
     * Boot the trait and apply the global scope.
     */
    protected static function bootBelongsToRestaurant(): void
    {
        static::addGlobalScope(new RestaurantScope);

        static::creating(function ($model) {
            if (Auth::hasUser() && Auth::user()->restaurant_id && empty($model->restaurant_id)) {
                $model->restaurant_id = Auth::user()->restaurant_id;
            }
        });
    }

    /**
     * Get the restaurant that owns the model.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
