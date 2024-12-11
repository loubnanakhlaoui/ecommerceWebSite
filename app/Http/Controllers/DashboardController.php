<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index() {
        $product = new Product();
        $order = new Order();
        $user = new User();

        return view('admin.dashboard', compact('product','order','user'));
    }
    public function getSalesData()
    {
        // Récupérer la quantité totale vendue par produit
        $salesData = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->groupBy('product_id')
            ->get();

        // Retourner les données sous forme de JSON pour les afficher avec AJAX
        return response()->json($salesData);
    }
}
