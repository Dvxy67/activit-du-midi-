<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'description', 
        'activity_date',
        'activity_time',
        'max_participants',
        'points_cost',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'activity_time' => 'datetime:H:i',
    ];

    // Relation : une activité a plusieurs utilisateurs inscrits
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // Méthode utile : places restantes
    public function availableSpots(): int
    {
        return $this->max_participants - $this->users->count();
    }

    // Méthode utile : vérifier si un utilisateur est inscrit
    public function hasUser($userId): bool
    {
        return $this->users->contains($userId);
    }

    // Méthode utile : vérifier si l'activité est complète
    public function isFull(): bool
    {
        return $this->availableSpots() <= 0;
    }
}