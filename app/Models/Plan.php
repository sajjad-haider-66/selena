<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_number',
        'main_enterprise_1',
        'subcontractor_1',
        'speaker_1',
        'main_enterprise_2',
        'subcontractor_2',
        'speaker_3',
        'location',
        'start_time',
        'end_time',
        'operation_description',
        'operative_mode_number',
        'interference_risks',
        'work_nature',
        'risk_nature',
        'training_certifications',
        'pir_pirl',
        'technical_document',
        'crane',
        'work_start_declaration',
        'scaffolding',
        'network_plans',
        'degassing_certificate',
        'fire_permit',
        'specific_permit',
        'other_permit',
    ];
}
