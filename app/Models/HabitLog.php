<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HabitLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'habit_id',
        'utilisateur_id',
        'complete_le',
        'note'
    ];

    protected $casts = ['complete_le' => 'date'];

    // un journal appartient à une habitude relation inevrs ecar dans Habit on avait mis un hasmany pour la gestiondes journaux
    public function habitude(): BelongsTo
    {
        return $this->belongsTo(Habit::class, 'habit_id');
    }

    // un journal appartient à un utilisateur pareil qu'en haut
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}
