<?php

// AdminUser.php (Modèle)
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mutateur pour hacher le mot de passe avant de l'enregistrer.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        // Le mot de passe est haché ici, si ce n'est pas déjà le cas.
        $this->attributes['password'] = bcrypt($value);
    }
}
