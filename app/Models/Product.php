<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    // Relation avec les éléments de commande
    public function orderItems()
    {
        return $this->hasMany(OrderItems::class);
    }

    // Méthode pour calculer le nombre total de ventes
    public function getTotalSalesAttribute()
    {
        return $this->orderItems()->sum('quantity');
    }
}