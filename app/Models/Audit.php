<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audits';
    protected $primaryKey = 'id';
    protected $fillable = [
        'date',
        'site',
        'auditor',
        'intervenant',
        'themes_comments',
        'mission_score',
        'mission_comments',
        'risks_score',
        'risks_comments',
        'trainings_score',
        'trainings_comments',
        'authorizations_score',
        'authorizations_comments',
        'env_risks_score',
        'env_risks_comments',
        'access_score',
        'access_comments',
        'safety_score',
        'safety_comments',
        'mase_score',
        'mase_comments',
        'prevention_score',
        'prevention_comments',
        'client_expectations_score',
        'client_expectations_comments',
        'feedback_score',
        'feedback_comments',
        'last_causerie_score',
        'last_causerie_comments',
        'sse_score',
        'sse_comments',
        'actions'
    ];
    protected $casts = [
        'actions' => 'array',
    ];
    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];
    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('d/m/Y') : null;
    }
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : null;
    }
    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null;
    }
    public function getActionsAttribute($value)
    {
        return json_decode($value, true);
    }
    public function setActionsAttribute($value)
    {
        $this->attributes['actions'] = json_encode($value);
    }
    public function getMissionScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getRisksScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getTrainingsScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getAuthorizationsScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getEnvRisksScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getAccessScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getSafetyScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getMaseScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getPreventionScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getClientExpectationsScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getFeedbackScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getLastCauserieScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getSseScoreAttribute($value)
    {
        return $value ? strtoupper($value) : null;
    }
    public function getFormattedActionsAttribute()
    {
        return collect($this->actions)->map(function ($action) {
            return [
                'origin' => $action['origin'],
                'description' => $action['description'],
                'action_type' => $action['action_type'],
                'pilot_id' => $action['pilot_id'],
                'due_date' => $action['due_date'],
                'start_date' => $action['start_date'] ?? null,
                'end_date' => $action['end_date'] ?? null,
                'verifier_id' => $action['verifier_id'] ?? null,
                'verified_date' => $action['verified_date'] ?? null,
                'progress' => $action['progress'] ?? 0,
                'efficiency' => $action['efficiency'] ?? null,
                'comment' => $action['comment'] ?? null,
                'status' => $action['status'] ?? 'Not Started',
            ];
        })->toArray();
    }
    public function getFormattedActionsForDisplayAttribute()
    {
        return collect($this->formatted_actions)->map(function ($action) {
            return [
                'origin' => $action['origin'],
                'description' => $action['description'],
                'action_type' => $action['action_type'],
                'pilot_id' => $action['pilot_id'],
                'due_date' => $action['due_date'] ? \Carbon\Carbon::parse($action['due_date'])->format('d/m/Y') : null,
                'start_date' => $action['start_date'] ? \Carbon\Carbon::parse($action['start_date'])->format('d/m/Y') : null,
                'end_date' => $action['end_date'] ? \Carbon\Carbon::parse($action['end_date'])->format('d/m/Y') : null,
                'verifier_id' => $action['verifier_id'],
                'verified_date' => $action['verified_date'] ? \Carbon\Carbon::parse($action['verified_date'])->format('d/m/Y') : null,
                'progress' => $action['progress'],
                'efficiency' => $action['efficiency'],
                'comment' => $action['comment'],
                'status' => $action['status'],
            ];
        })->toArray();
    }
}
