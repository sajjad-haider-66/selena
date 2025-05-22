<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $table = 'checklists';
    protected $fillable = [
        'readiness_form_id',
        'question',
        'answer',
        'score',
    ];
}
