<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistAnswer extends Model
{
    use HasFactory;
    protected $table = 'checklist_answers';
    protected $fillable = [
        'readiness_form_id',
        'question',
        'answer',
        'score',
    ];
    protected $casts = [
        'score' => 'integer',
    ];
    public function readinessForm()
    {
        return $this->belongsTo(ReadinessForm::class);
    }
    public function getScoreAttribute($value)
    {
        return (int) $value; // Ensure score is always an integer
    }
    public function setScoreAttribute($value)
    {
        $this->attributes['score'] = (int) $value; // Store score as an integer
    }
}
