<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadinessForm extends Model
{
    protected $table = 'readiness_forms';
    protected $fillable = ['date', 'site_name',
     'company_name',
     'commentaires',
     'nom',
     'entreprise',
      'permit_number', 'user_id', 'checklist_data', 'readiness_rate', 'status'
    ];
    protected $casts = [
        'checklist_data' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class, 'form_id', 'form_id');
    }
}
