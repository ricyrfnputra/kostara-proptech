<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    protected $fillable = ['room_number', 'price', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    // Penghuni aktif kamar ini (maksimal 1)
    public function tenant(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    // "Terisi" dihitung dari ada tidaknya penghuni, bukan disimpan
    public function isOccupied(): bool
    {
        return $this->tenant()->exists();
    }
}