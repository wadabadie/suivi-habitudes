<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    use HasFactory;
    // app/Models/Friend.php

    protected $fillable = [
        'utilisateur_id',
        'ami_id',
        'statut'
    ];

    //  la demande appartient à l'utilisateur qui l'a envoyée
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    // la demande cible cet ami
    public function ami(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ami_id');
    }

    // on Vérifie si la demande est acceptée
    public function estAcceptee(): bool
    {
        return $this->statut === 'accepte';
    }

    // on Vérifie si la demande est en attente
    public function estEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }

}
