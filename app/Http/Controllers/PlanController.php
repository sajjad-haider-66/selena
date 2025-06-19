<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //KEY : MULTIPERMISSION
        $this->middleware('permission:plan-list|plan-create|plan-edit|plan-show|plan-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:plan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:plan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:plan-delete', ['only' => ['destroy']]);
        $this->middleware('permission:plan-show', ['only' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::get();
        return view('plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'plan_number' => 'required|string|unique:plans,plan_number',
            'work_date' => 'nullable|date',
            'company_name_detail' => 'nullable|array',
            'location' => 'nullable|string|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'depotage_time' => 'nullable|date_format:H:i',
            'presence_zone' => 'nullable|string|max:255',
            'other_works' => 'nullable|string',
            'description' => 'nullable|string',
            'operative_mode_number' => 'nullable|string|max:255',
            'travail' => 'nullable|array',
            'travail.*' => 'string', // Each item in travail array is a string
            'work_nature_other' => 'nullable|string',
            'risques' => 'nullable|array',
            'risques.*' => 'string',
            'risk_nature_other' => 'nullable|string',
            'formations' => 'nullable|array',
            'formations.*' => 'string',
            'training_certifications_other' => 'nullable|string',
            'before_date' => 'nullable|date',
            'before_time' => 'nullable|date_format:H:i',
            'before_responsible_name' => 'nullable|string|max:255',
            'apres_travail_non_termine' => 'nullable|string', // 'on' or null
            'new_authorization_date' => 'nullable|date',
            'company_nom_date' => 'nullable|array',
            'avant_entreprise' => 'nullable|array',
            'after_responsible_date' => 'nullable|date',
            'after_responsible_time' => 'nullable|date_format:H:i',
            'after_responsible_name' => 'nullable|string|max:255',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $nomList = $request->input('apres_entreprise_nom', []);
        $dateList = $request->input('apres_entreprise_date', []);
 
        // Create an array of company names and dates
        $companyNomDate = [];
        for ($i = 0; $i < count($nomList); $i++)
        {
            $companyNomDate[] = [
                'name' => $nomList[$i],
                'date' => $dateList[$i],
            ];
        }

        $external_company = $request->input('external_company', []);
        $main_company = $request->input('main_company', []);
        $subcontractor = $request->input('subcontractor', []);
        $intervenant = $request->input('intervenant', []);

        $comNomEntreprises = [];

        foreach ($external_company as $index => $comnom) {
            $comNomEntreprises[] = [
                'external_company' => $comnom,
                'main_company' => $main_company[$index] ?? null, // agar date missing ho to null
                'subcontractor' => $subcontractor[$index] ?? null, // agar date missing ho to null
                'intervenant' => $intervenant[$index] ?? null, // agar date missing ho to null
            ];
        }
        
        $avant_entreprise = $request->input('avant_entreprise', []);
        $avantEntreprises = [];
        foreach ($avant_entreprise as $key => $value) {
            $avantEntreprises[] = [
                'name' => $value,
            ];
        }


        // Create a new Plan instance
        $plan = new Plan();

        // Map form data to database fields
        $plan->plan_number = $request->input('plan_number');
        $plan->work_date = $request->input('work_date');
        $plan->company_name_detail = $comNomEntreprises ? json_encode($comNomEntreprises) : null; // Store as JSON
        $plan->location = $request->input('location');
        $plan->start_time = $request->input('start_time');
        $plan->end_time = $request->input('end_time');
        $plan->depotage_time = $request->input('depotage_time');
        $plan->presence_zone = $request->input('presence_zone');
        $plan->other_works = $request->input('other_works');
        $plan->description = $request->input('description');
        $plan->operative_mode_number = $request->input('operative_mode_number');
        
        // Serialize array fields as JSON
        $plan->work_nature = $request->input('travail') ? json_encode($request->input('travail')) : null;
        $plan->work_nature_other = $request->input('work_nature_other');
        $plan->risk_nature = $request->input('risques') ? json_encode($request->input('risques')) : null;
        $plan->risk_nature_other = $request->input('risk_nature_other');
        $plan->training_certifications = $request->input('formations') ? json_encode($request->input('formations')) : null;
        $plan->training_certifications_other = $request->input('training_certifications_other');
        
        // Map 'avant' fields
        $plan->avant_entreprise = $avantEntreprises ? json_encode($avantEntreprises) : null;
        $plan->before_date = $request->input('before_date');
        $plan->before_time = $request->input('before_time');
        $plan->before_responsible_name = $request->input('before_responsible_name');
        
        // Handle boolean for work_not_completed
        $plan->work_not_completed = $request->input('apres_travail_non_termine') === 'on';
        
        // Map 'apres' fields
        $plan->new_authorization_date = $request->input('new_authorization_date');
        $plan->company_nom_date = $companyNomDate ? json_encode($companyNomDate) : null;
        $plan->after_responsible_date = $request->input('after_responsible_date');
        $plan->after_responsible_time = $request->input('after_responsible_time');
        $plan->after_responsible_name = $request->input('after_responsible_name');

        // Map boolean fields from travail array (if present)
        $travail = $request->input('travail', []);
        $plan->crane = in_array('Grue', $travail);
        $plan->scaffolding = in_array('Echafaudage', $travail);
        $plan->work_start_declaration = in_array('Déclaration d’Intention de', $travail);
        $plan->network_plans = in_array('Plans de réseaux', $travail);
        $plan->degassing_certificate = in_array('Certificat de dégazage', $travail);

        // Map permit fields from formations array (if present)
        $formations = $request->input('formations', []);
        $plan->fire_permit = in_array('Permis de feu', $formations) ? 'Permis de feu' : $request->input('fire_permit');
        $plan->specific_permit = in_array('Permis spécifique :', $formations) ? 'Permis spécifique' : $request->input('specific_permit');
        $plan->other_permit = $request->input('other_permit');

        // Save the plan to the database
        $plan->save();

        // Redirect or return response
        return redirect()->route('plan.index')->with('success', 'Plan created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plans = Plan::where('id', $id)->first();
        return view('plans.show', compact('plans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Display the edit form
    public function edit(Plan $plan)
    {
        return view('plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
     // Update the plan
    public function update(Request $request, Plan $plan)
    {
        
              // Define validation rules
        $rules = [
            // 'plan_number' => 'required|string|plan_number',
            'work_date' => 'nullable|date',
            'company_name_detail' => 'nullable|array',
            'location' => 'nullable|string|max:255',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'depotage_time' => 'nullable|date_format:H:i',
            'presence_zone' => 'nullable|string|max:255',
            'other_works' => 'nullable|string',
            'description' => 'nullable|string',
            'operative_mode_number' => 'nullable|string|max:255',
            'travail' => 'nullable|array',
            'travail.*' => 'string',
            'work_nature_other' => 'nullable|string',
            'risques' => 'nullable|array',
            'company_nom_date' => 'nullable|array',
            'avant_entreprise' => 'nullable|array',
        ];
        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $nomList = $request->input('apres_entreprise_nom', []);
        $dateList = $request->input('apres_entreprise_date', []);
 
        // Create an array of company names and dates
        $companyNomDate = [];
        for ($i = 0; $i < count($nomList); $i++)
        {
            $companyNomDate[] = [
                'name' => $nomList[$i],
                'date' => $dateList[$i],
            ];
        }

        $external_company = $request->input('external_company', []);
        $main_company = $request->input('main_company', []);
        $subcontractor = $request->input('subcontractor', []);
        $intervenant = $request->input('intervenant', []);

        $comNomEntreprises = [];

        foreach ($external_company as $index => $comnom) {
            $comNomEntreprises[] = [
                'external_company' => $comnom,
                'main_company' => $main_company[$index] ?? null, // agar date missing ho to null
                'subcontractor' => $subcontractor[$index] ?? null, // agar date missing ho to null
                'intervenant' => $intervenant[$index] ?? null, // agar date missing ho to null
            ];
        }
        
        $avant_entreprise = $request->input('avant_entreprise', []);
        $avantEntreprises = [];
        foreach ($avant_entreprise as $key => $value) {
            $avantEntreprises[] = [
                'name' => $value,
            ];
        }

        // Map form data to database fields
        $plan->plan_number = $request->input('plan_number');
        $plan->work_date = $request->input('work_date');
        $plan->company_nom_date = $companyNomDate ? json_encode($companyNomDate) : null;
        $plan->location = $request->input('location');
        $plan->start_time = $request->input('start_time');
        $plan->end_time = $request->input('end_time');
        $plan->depotage_time = $request->input('depotage_time');
        $plan->presence_zone = $request->input('presence_zone');
        $plan->other_works = $request->input('other_works');
        $plan->description = $request->input('description');
        $plan->operative_mode_number = $request->input('operative_mode_number');
        
        // Serialize array fields as JSON
        $plan->work_nature = $request->input('travail') ? json_encode($request->input('travail')) : null;
        $plan->work_nature_other = $request->input('work_nature_other');
        $plan->risk_nature = $request->input('risques') ? json_encode($request->input('risques')) : null;
        $plan->risk_nature_other = $request->input('risques_autre');
        $plan->training_certifications = $request->input('formations') ? json_encode($request->input('formations')) : null;
        $plan->training_certifications_other = $request->input('training_certifications_other');
        
        // Map 'avant' fields
        $plan->avant_entreprise = $avantEntreprises ? json_encode($avantEntreprises) : null;
        $plan->before_date = $request->input('before_date');
        $plan->before_time = $request->input('before_time');
        $plan->before_responsible_name = $request->input('before_responsible_name');
        
        // Handle boolean fields
        $plan->work_completed = $request->input('apres_travail_termine') === 'on';
        $plan->work_not_completed = $request->input('apres_travail_non_termine') === 'on';
        $plan->station_normal = $request->input('apres_station_normale') === 'on';
        $plan->site_clean_safe = $request->input('apres_chantier_propre') === 'on';
        
        // Map 'apres' fields
        $plan->new_authorization_date = $request->input('new_authorization_date');
        $plan->company_name_detail = $comNomEntreprises ? json_encode($comNomEntreprises) : null; // Store as JSON
        $plan->after_responsible_date = $request->input('after_responsible_date');
        $plan->after_responsible_time = $request->input('after_responsible_time');
        $plan->after_responsible_name = $request->input('after_responsible_name');

        // Map boolean fields from travail array (if present)
        $travail = $request->input('travail', []);
        $plan->crane = in_array('Grue', $travail);
        $plan->scaffolding = in_array('Echafaudage', $travail);
        $plan->pir_pirl = in_array('PIR / PIRL', $travail);
        $plan->work_start_declaration = in_array('Déclaration d’Intention de', $travail);
        $plan->network_plans = in_array('Plans de réseaux', $travail);
        $plan->degassing_certificate = in_array('Certificat de dégazage', $travail);
        $plan->technical_document = in_array('Document Technique', $travail);

        // Map permit fields from formations array (if present)
        $formations = $request->input('formations', []);
        $plan->fire_permit = in_array('Permis de feu', $formations) ? 'Permis de feu' : $request->input('fire_permit');
        $plan->specific_permit = in_array('Permis spécifique :', $formations) ? 'Permis spécifique' : $request->input('specific_permit');
        $plan->other_permit = $request->input('other_permit');

        // Save the updated plan
        $plan->save();

        // Redirect to index with success message
        return redirect()->route('plan.index')->with('success', 'Plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Plan = Plan::FindOrFail($id);
        $Plan->delete();
        return $this->success('Plan Delete Successfully', ['success' => true, 'data' => null]);
    }
}
