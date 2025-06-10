<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_number',
        'work_date',
        'external_company_1',
        'main_company_1',
        'subcontractor_1',
        'intervenant_1',
        'external_company_2',
        'main_company_2',
        'subcontractor_2',
        'intervenant_2',
        'location',
        'start_time',
        'end_time',
        'depotage_time',
        'presence_zone',
        'other_works',
        'description',
        'operative_mode_number',
        'work_nature',
        'work_nature_other',
        'risk_nature',
        'risk_nature_other',
        'training_certifications',
        'training_certifications_other',
        'before_company_1',
        'before_company_2',
        'before_company_3',
        'before_date',
        'before_time',
        'before_responsible_name',
        'work_not_completed',
        'new_authorization_date',
        'after_company_1_name',
        'after_company_1_date',
        'after_company_2_name',
        'after_company_2_date',
        'after_responsible_date',
        'after_responsible_time',
        'after_responsible_name',
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

    protected $casts = [
        'work_date' => 'date',
        'before_date' => 'date',
        'new_authorization_date' => 'date',
        'after_company_1_date' => 'date',
        'after_company_2_date' => 'date',
        'after_responsible_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'depotage_time' => 'datetime:H:i',
        'before_time' => 'datetime:H:i',
        'after_responsible_time' => 'datetime:H:i',
        'work_not_completed' => 'boolean',
        'pir_pirl' => 'boolean',
        'technical_document' => 'boolean',
        'crane' => 'boolean',
        'work_start_declaration' => 'boolean',
        'scaffolding' => 'boolean',
        'network_plans' => 'boolean',
        'degassing_certificate' => 'boolean',
    ];
}
