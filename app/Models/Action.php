<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Action extends Model
{
    use HasFactory;
    
    protected $table = 'actions';
    protected $fillable = [
        'origin', 'description', 'issued_date', 'type', 'pilot_id',
        'start_date', 'end_date', 'verified_date', 'progress_rate', 'efficiency',
        'comments', 'json_data', 'due_date',
        'action_form_type', 'improvements', 'emission',
        'action_number', 'auditor', 'checked_on',
        'action_origin', 'origin_view_id',
        'verifier_id',
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

    public function generateNotification()
    {
        // return new Notification;
    }

    public function calculateProgressRate()
    {
        $progress = 0;

        // Base progress rates
        if ($this->start_date) $progress += 25; // Action Started On -> 25%
        if ($this->end_date) $progress += 25;   // Action Completed On -> 25%
        if ($this->checked_on) $progress += 20; // Action Verified On -> 20%

        // Emission Date + Deadline logic
        $emissionDate = Carbon::parse($this->start_date);
        $dueDate = Carbon::parse($this->due_date);
        $completionDate = $this->end_date ? Carbon::parse($this->end_date) : null;
        $checkedDate = $this->checked_on ? Carbon::parse($this->checked_on) : null;

        // Calculate deadline end (emission date + due date duration)
        $deadlineEnd = $emissionDate->copy()->addDays($dueDate->diffInDays($emissionDate));

        if ($completionDate) {
            if ($completionDate->lte($deadlineEnd)) {
                $progress += 30; // +30% if completed on or before deadline
            } else {
                $progress += 0;  // +0% if completed after deadline
            }

            // Special cases
            if ($checkedDate) {
                if ($completionDate->lte($deadlineEnd)) {
                    $progress = 100; // 100% if completed on time and verified
                } else {
                    $progress = 25 + 25 + 20; // 70% if completed late and verified
                }
            } else {
                if ($completionDate->lte($deadlineEnd)) {
                    $progress = 25 + 25 + 30; // 80% if completed on time but not verified
                } else {
                    $progress = 25 + 25; // 50% if completed late but not verified
                }
            }
        } elseif (!$this->start_date && !$this->end_date && !$this->checked_on) {
            $progress = 0; // 0% if no fields are filled
        }

        // Ensure progress doesn't exceed 100
        $this->progress_rate = min($progress, 100);

        // Calculate efficiency
        $this->efficiency = ($this->progress_rate >= 80) ? 'O' : 'N';

        $this->save();
    }
}
