<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $fillable = [
        'date', 'lieu', 'type', 'emetteur', 'securite', 'sante', 'environnement', 'rse',
        'circonstances', 'risques', 'analyse', 'cotation', 'frequence', 'gravite',
        'propositions', 'mesures', 'actions', 'attachments', 'validated'
    ];

    protected $casts = [
        'analyse' => 'array',
        'propositions' => 'array',
        'mesures' => 'array',
        'actions' => 'array',
        'attachments' => 'array',
    ];
}
