<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceRecord extends Model
{
    protected $fillable = [
        'report_id', 'technician', 'cost', 'maintenance_date', 'notes',
    ];

    protected function casts(): array
    {
        return ['maintenance_date' => 'date'];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}