<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Ajout de l'import Auth

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ajout du middleware auth pour protéger les routes
    }

    public function index() 
    {
        $user = Auth::user(); // Version simplifiée pour récupérer l'utilisateur connecté
        return view('front.profile.index', compact('user'));
    }

    public function show($id) 
    {
        $order = Order::findOrFail($id); // Utilisation de findOrFail pour une meilleure gestion des erreurs
        
        // Vérification que l'utilisateur accède à ses propres commandes
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('front.profile.details', compact('order'));
    }
}