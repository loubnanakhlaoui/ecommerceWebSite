<?php

namespace App\Http\Controllers\Front;

use App\Services\Cart;  // Mise à jour du namespace pour votre classe Cart
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        return view('front.cart.index');
    }

    public function store(Request $request)
{
    // Vérifier si l'article existe déjà dans le panier
    $cartItems = $this->cart->instance('default')->getContent();
    $duplicate = $cartItems->first(function ($item) use ($request) {
        return $item['id'] == $request->id;
    });

    if ($duplicate) {
        return redirect()->back()->with('msg', 'Item is already in your cart');
    }

    // Ajouter l'article au panier avec les options
    $this->cart->instance('default')->add(
        $request->id,
        $request->name,
        1,
        $request->price,
        [
            'image' => $request->image ?? 'default-product.jpg',
            'description' => $request->description ?? ''
        ]
    );

    return redirect()->back()->with('msg', 'Item has been added to cart');
}

    public function destroy($id)
    {
        $this->cart->instance('default')->remove($id);

        return redirect()->back()->with('msg', 'Item has been removed from cart');
    }

    public function saveLater($id)
{
    $cartItems = $this->cart->instance('default')->getContent();
    $item = $cartItems->first(function ($cartItem) use ($id) {
        return $cartItem['id'] == $id;
    });

    if (!$item) {
        return redirect()->back()->with('error', 'Item not found');
    }

    $this->cart->instance('default')->remove($id);

    $savedItems = $this->cart->instance('saveForLater')->getContent();
    $duplicate = $savedItems->first(function ($cartItem) use ($id) {
        return $cartItem['id'] == $id;
    });

    if ($duplicate) {
        return redirect()->back()->with('msg', 'Item is save for later');
    }

    $this->cart->instance('saveForLater')->add(
        $item['id'],
        $item['name'],
        1,
        $item['price'],
        $item['options'] ?? [] // Conserver les options lors du déplacement
    );

    return redirect()->back()->with('msg', 'Item has been saved for later');
}

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if ($validator->fails()) {
            session()->flash('errors', 'Quantity must be between 1 and 5');
            return response()->json(['success' => false]);
        }

        $this->cart->instance('default')->update($id, $request->quantity);

        session()->flash('msg', 'Quantity has been updated');

        return response()->json(['success' => true]);
    }
}