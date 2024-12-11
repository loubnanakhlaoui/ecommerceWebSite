<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Cart;  

class SaveLaterController extends Controller
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function destroy($id)
    {
        $this->cart->instance('saveForLater')->remove($id);
        
        return redirect()->back()->with('msg', 'Item has been removed from save for later');
    }

    public function moveToCart($id)
    {
        // Récupérer l'item depuis saveForLater
        $savedItems = $this->cart->instance('saveForLater')->getContent();
        $item = $savedItems->first(function ($cartItem) use ($id) {
            return $cartItem['id'] == $id;
        });

        if (!$item) {
            return redirect()->back()->with('error', 'Item not found');
        }

        // Retirer l'item de saveForLater
        $this->cart->instance('saveForLater')->remove($id);

        // Vérifier si l'item existe déjà dans le panier
        $cartItems = $this->cart->instance('default')->getContent();
        $duplicate = $cartItems->first(function ($cartItem) use ($id) {
            return $cartItem['id'] == $id;
        });

        if ($duplicate) {
            return redirect()->back()->with('msg', 'Item is already in cart');
        }

        // Ajouter l'item au panier principal
        $this->cart->instance('default')->add(
            $item['id'],
            $item['name'],
            1,
            $item['price'],
            $item['options'] ?? []
        );

        return redirect()->back()->with('msg', 'Item has been moved to cart');
    }
}