<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // Affiche la liste des utilisateurs
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Affiche les détails d'un utilisateur spécifique
    public function show($id)
    {
        // Récupérer l'utilisateur avec ses commandes et relations
        $user = User::with(['orders.products', 'orders.orderItems'])->find($id);

        // Vérifier si l'utilisateur existe
        if (!$user) {
            return redirect()->route('admin.users.index')->withErrors('User not found.');
        }

        // Retourner les données à la vue
        return view('admin.users.details', compact('user'));
    }
}
