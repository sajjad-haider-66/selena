<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkAnimation extends Model
{
    use HasFactory;
    protected $table = 'talks';
    protected $fillable = [
        'name',
        'description',
        'image',
        'video',
        'status',
        'created_by',
        'updated_by'
    ];
}
