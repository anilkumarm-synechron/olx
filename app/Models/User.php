<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPhoneAttribute($value)
    {
        if($value === null){
            $this->attributes['phone'] = null;
            return;
        }
        $digits = preg_replace('/[^0-9]/','', $value);
        if(strlen($digits) > 10){
            $digits = substr($digits, -10); // keep last 10 digits
        }
        if(strlen($digits) !== 10){
            $this->attributes['phone'] = null; // enforce null if invalid
        } else {
            $this->attributes['phone'] = $digits;
        }
    }
}