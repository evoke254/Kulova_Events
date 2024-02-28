<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable,  HasRoles;

    protected $roleLabels = [
        1 => 'Super Admin',
        2 => 'Admin',
        3 => 'Support',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'last_name'
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
    protected $allowed_admin_mails = [
        'text40.com',
        'gmail.com'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getEmailDomain($email){
        $array = explode('@', $email);
        return $array[1];
    }

    /*
        public function canAccessPanel(Panel $panel): bool
        {
            return str_ends_with($this->email, '@visuafusion.com') && $this->hasVerifiedEmail();
        }*/

    public function canAccessPanel(Panel$panel): bool
    {
        foreach ($this->allowed_admin_mails as $allowed_admin_mails){
            if (str_ends_with($this->email, $allowed_admin_mails) && $this->hasVerifiedEmail()) {
                return true;
            }
        }

        return  false;

    }
      public function getRoleNameAttribute()
    {
        return $this->roleLabels[$this->attributes['role_id']] ?? null;
    }

        public function events():HasMany
    {
        return $this->hasmany(Event::class);
    }

}
