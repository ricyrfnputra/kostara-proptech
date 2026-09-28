<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bill extends Model
{
    // Berapa hari sebelum jatuh tempo dianggap "mendekati"
    public const DUE_SOON_DAYS = 3;

    protected $fillable = [
        'user_id', 'room_id', 'amount', 'due_date', 'status', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function notificationLogs(): HasMany
    {
        return $this->hasMany(NotificationLog::class);
    }

    // Status tampilan dihitung dari tanggal hari ini, bukan disimpan
    public function displayStatus(): string
    {
        if ($this->status === 'paid') {
            return 'LUNAS';
        }

        $today = now()->startOfDay();

        if ($this->due_date->lt($today)) {
            return 'TUNGGAKAN';
        }

        if ($today->diffInDays($this->due_date) <= self::DUE_SOON_DAYS) {
            return 'MENDEKATI JATUH TEMPO';
        }

        return 'BELUM JATUH TEMPO';
    }
}