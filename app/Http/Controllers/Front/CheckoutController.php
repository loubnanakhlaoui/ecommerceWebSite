<?php

namespace App\Http\Controllers\Front;

use App\Models\OrderItems;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use App\Services\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->middleware('auth');
        $this->cart = $cart;
    }

    public function index()
    {
        return view('front.checkout.index');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'stripeToken' => 'required',
            'address' => 'required',
        ]);

        // Get cart total and sanitize it
        $total = $this->cart->instance('default')->getTotal();
        $total = (float) preg_replace('/[^\d.]/', '', $total);

        if ($total <= 0) {
            return redirect()->back()->with('error', 'Invalid cart total.');
        }

        try {
            // Set Stripe API version explicitly
            Stripe::setApiVersion('2020-08-27');
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create payment intent
            $charge = Stripe::charges()->create([
                'amount' => (int)($total * 100), // Convert to cents and ensure integer
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Order ' . time(),
                'metadata' => [
                    'quantity' => $this->cart->instance('default')->count()
                ]
            ]);

            // Create order only if charge is successful
            $order = Order::create([
                'user_id' => Auth::id(),
                'date' => Carbon::now(),
                'address' => $request->address,
                'status' => 0,
                'transaction_id' => $charge['id'] // Store the Stripe transaction ID
            ]);

            // Create order items
            foreach ($this->cart->instance('default')->getContent() as $item) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price']
                ]);
            }

            // Clear cart
            $this->cart->instance('default')->clear();

            return redirect()->route('order.success')->with('success', 'Your order has been processed successfully!');

        } catch (\Exception $e) {
            \Log::error('Stripe Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }
    public function success()
{
    return view('front.checkout.success');
}

}