<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkAnimation extends Model
{
    use HasFactory;
 protected $table = 'talks';
    protected $fillable = [
        'date', 'lieu', 'theme', 'animateur', 'signature',
        'security', 'health', 'environment', 'rse',
        'points', 'commentaires', 'participants', 'actions',
        'materials', 'feedback', 'stats', 'notes'
    ];

    protected $casts = [
        'participants' => 'array',
        'actions' => 'array',
        'materials' => 'array',
        'feedback' => 'array',
        'stats' => 'array',
    ];
}
