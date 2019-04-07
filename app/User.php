<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    
    protected $dates = ['deleted_at'];

    //constantes para verificado o no
    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';

    //constantes para usuario, si es admin o no
    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];
    /**
@@ -24,6 +37,23 @@ class User extends Authenticatable
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
        'password',
        'remember_token',
        'verification_token',
    ];

    public function setNameAttribute($valor)
    {
        $this->attributes['name'] = strtolower($valor);
    }

    public function getNameAttribute($valor)
    {
        return ucwords($valor);//toda palabra con primera letra en mayuscula
        //return ucfirst($valor);
    }

    public function setEmailAttribute($valor)
    {
        $this->attributes['email'] = strtolower($valor);
    }

    //avisa si el usuario es verificado o no
    public function esVerificado()
    {
        return $this->verified == User::USUARIO_VERIFICADO;
    }
    //avisa si el usuario es admin o no
    public function esAdministrador()
    {
        return $this->admin == User::USUARIO_ADMINISTRADOR;
    }
    //permite generar un token de verificacion
    public static function generarVerificationToken()
    {
        return str_random(40);
    }
}
