<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google2fa_secret',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //gestion de mon l'authentification avec Google authenticator
    public function setGoogle2faSecretAttribute($value)
    {
        $this->attributes['google2fa_secret'] = encrypt($value);
    }
    public function getGoogle2faSecretAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    // Un utilisateur a plusieurs habitudes
    public function habitudes(): HasMany
    {
        return $this->hasMany(Habit::class, 'utilisateur_id');
    }

    // Un utilisateur a plusieurs journaux
    public function journaux(): HasMany
    {
        return $this->hasMany(HabitLog::class, 'utilisateur_id');
    }

    // Un utilisateur a plusieurs amis
    public function amis(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'utilisateur_id', 'ami_id')
                ->wherePivot('statut', 'accepte');
    }
}
