<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    // Applique le middleware pour s'assurer que seuls les invités peuvent accéder à la page de connexion
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Affiche la page de connexion
    public function index() {
        return view('front.sessions.index');
    }

    // Traite la connexion de l'utilisateur
    public function store(Request $request){
        // Validation des données envoyées par l'utilisateur
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $request->validate($rules);
    
        // Récupère les données de connexion
        $data = $request->only('email', 'password');
    
        // Vérifie les informations d'identification avec Auth::attempt()
        if (!Auth::attempt($data)) {  // Utilisation correcte de la façade Auth
            return back()->withErrors([
                'message' => 'Wrong credentials, please try again.'
            ]);
        }
    
        // Redirige vers le profil de l'utilisateur après une connexion réussie
        return redirect()->route('user.profile'); // Utilisation d'une route nommée pour la redirection
    }
    
    // Déconnecte l'utilisateur
    public function logout() {
        Auth::logout(); // Utilisation correcte de la façade Auth

        session()->flash('msg', 'You have been logged out successfully');

        return redirect('/user/login'); // Redirection vers la page de connexion
    }
}
