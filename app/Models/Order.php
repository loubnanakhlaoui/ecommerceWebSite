<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    // Relation avec User
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relation avec OrderItems
    public function orderItems() {
        return $this->hasMany(OrderItems::class);
    }

    // Relation avec Products via la table pivot "order_items"
    public function products() {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('price', 'quantity') // Colonnes supplémentaires dans la table pivot
                    ->withTimestamps(); // Si vous suivez les conventions Laravel pour les timestamps
    }

    
}
