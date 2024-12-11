<?php

namespace App\Services;

use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

class Cart
{
    protected $session;
    protected $instance;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
        $this->instance = 'default';
    }

    public function instance($instance = null)
    {
        if ($instance) {
            $this->instance = $instance;
        }
        return $this;
    }

    public function add($id, $name, $qty, $price, $options = [])
    {
        $cartItems = $this->getContent();

        $cartItems->push([
            'id' => $id,
            'name' => $name,
            'qty' => $qty,
            'price' => (float) $price,
            'options' => $options,
        ]);

        $this->session->put($this->getInstance(), $cartItems);

        return $this;
    }

    public function update($id, $qty)
    {
        $cartItems = $this->getContent();

        $cartItems = $cartItems->map(function($item) use ($id, $qty) {
            if ($item['id'] == $id) {
                $item['qty'] = $qty;
            }
            return $item;
        });

        $this->session->put($this->getInstance(), $cartItems);

        return $this;
    }

    public function remove($id)
    {
        $cartItems = $this->getContent();

        $cartItems = $cartItems->filter(function ($item) use ($id) {
            return $item['id'] != $id;
        });

        $this->session->put($this->getInstance(), $cartItems);

        return $this;
    }

    public function count()
    {
        return $this->getContent()->sum('qty');
    }

    public function getContent()
    {
        return collect($this->session->get($this->getInstance(), []));
    }

    public function getSubtotal()
    {
        $subtotal = $this->getContent()->reduce(function ($total, $item) {
            return $total + ($item['price'] * $item['qty']);
        }, 0);

        return number_format($subtotal, 2);
    }

    public function getTax()
    {
        $subtotal = (float) str_replace(',', '', $this->getSubtotal());
        $tax = $subtotal * 0.10; // 10% tax rate
        return number_format($tax, 2);
    }

    public function getTotal()
    {
        $subtotal = (float) str_replace(',', '', $this->getSubtotal());
        $tax = (float) str_replace(',', '', $this->getTax());
        return number_format($subtotal + $tax, 2);
    }

    protected function getInstance()
    {
        return 'cart_' . $this->instance;
    }

    public function clear()
    {
        $this->session->forget($this->getInstance());
    }
    
}