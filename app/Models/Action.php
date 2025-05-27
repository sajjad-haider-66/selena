<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;
    
    protected $table = 'actions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'origin', 'origin_id', 'description', 'issued_date', 'type', 'responsible_id',
        'start_date', 'end_date', 'verified_date', 'progress_rate', 'efficiency',
        'comments', 'json_data' // To store origin and actions arrays
    ];

    protected $casts = [
        'issued_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'verified_date' => 'datetime',
        'progress_rate' => 'integer',
        'json_data' => 'array',
    ];

    public function responsible()
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function updateProgress(float $progress): bool
    {
        $this->progress_rate = $progress;
        return $this->save();
    }

    public function verifyEfficiency(): bool
    {
        $this->verified_date = now();
        return $this->save();
    }

    public function generateNotification(): Notification
    {
        return new \App\Notifications\ActionNotification($this);
    }
}
