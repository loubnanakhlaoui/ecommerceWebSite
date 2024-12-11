<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Les attributs pouvant être assignés en masse.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Les attributs qui doivent être cachés pour les tableaux.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mutateur pour s'assurer que le mot de passe est toujours haché avant d'être enregistré.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Relation avec le modèle Order (un utilisateur peut avoir plusieurs commandes).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
{
    return $this->hasMany(Order::class);
}

}
