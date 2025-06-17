<?php

namespace App\Models;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TalkAnimation extends Model
{
    use HasFactory;
 protected $table = 'talks';
    protected $fillable = [
        'date', 'lieu', 'theme', 'animateur', 'signature',
        'security', 'health', 'environment', 'rse',
        'points', 'commentaires', 'participants', 'actions',
        'materials', 'feedback', 'status', 'notes', 'created_by','path',
    ];

    protected $casts = [
        'participants' => 'array',
        'actions' => 'array',
        'materials' => 'array',
        'feedback' => 'array',
        'animateur' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'talk_id');
    }
}
