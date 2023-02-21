<?php

namespace App\Models;

use App\Http\Traits\HasPermissionsTrait;
use App\Http\Traits\HasProfilePhoto;
use App\Http\Traits\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasProfilePhoto, HasPermissionsTrait, TwoFactorAuthenticatable;
    //unsed
    const ROLE_ADMIN = 1;
    const ROLE_USER = 0;
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fb_id',
        'google_id',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['profile_photo_url'];

    ################BEGIN_WITHOUT_TABLE_ROLE
    // public static function roleNameFor($role)
    // {
    //  return   match($role) {
    //         static::ROLE_ADMIN => 'admin',
    //         static::ROLE_USER=>'user',
    //     };
    // }
    // /**
    //  * The attributes that should be cast.
    //  *
    //  * @var string
    //  */
    // public function roleName():string
    // {
    //   return static::roleNameFor($this->role);//when doesn't use roles table

    // }

    // public function IsAdmin():bool
    // {
    //     return static::ROLE_ADMIN === $this->role;
    // }
    ################END_WITHOUT_TABLE_ROLE

    public function IsAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    //     /**
    //      * decrypt twoFactorRecoveryCodes 
    //      */
    //     protected function twoFactorRecoveryCodes(): Attribute
    //     {
    //         return Attribute::make(
    //             get: fn (string $value) =>  json_encode(decrypt($value)));
    //     }
}
