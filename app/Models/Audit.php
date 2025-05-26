<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

     protected $table = 'audits';
    protected $fillable = [
        'date', 'lieu', 'auditeur', 'intervenant', 'responses', 'culture_sse', 'actions'
    ];

    protected $casts = [
        'responses' => 'array',
        'actions' => 'array',
    ];
}
