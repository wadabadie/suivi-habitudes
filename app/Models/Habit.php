<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habit extends Model
{
    use HasFactory;
    protected $fillable = [
        'utilisateur_id',
        'nom',
        'description',
        'frequence',
        'couleur',
        'est_actif'
    ];

    protected $casts = ['est_actif' => 'boolean'];

    //  une habitude appartient à un utilisateur(belognsTo relation inverse)
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    // une habitude a plusieurs journaux Hasmany
    public function journaux(): HasMany
    {
        return $this->hasMany(HabitLog::class, 'habit_id');
    }


    public function estFaiteAujourdhui(): bool
    {
        return $this->journaux()
            ->whereDate('complete_le', today())
            ->exists();
    }


    public function obtenirSerie(): int
    {
        $serie = 0;
        $date = today();

        while (true) {
            $existe = $this->journaux()
                ->whereDate('complete_le', $date)
                ->exists();

            if (!$existe) break;

            $serie++;
            $date = $date->subDay();
        }

        return $serie;
    }
}
