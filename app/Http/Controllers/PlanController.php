<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

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
        $validated = $request->validate([
            'plan_number' => 'required|',
            'main_enterprise_1' => 'nullable|string',
            'subcontractor_1' => 'nullable|string',
            'speaker_1' => 'nullable|string',
            'main_enterprise_2' => 'nullable|string',
            'subcontractor_2' => 'nullable|string',
            'speaker_3' => 'nullable|string',
            'location' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'operation_description' => 'nullable|string',
            'operative_mode_number' => 'nullable|string',
            'interference_risks' => 'nullable|string',
            'work_nature' => 'nullable|string',
            'risk_nature' => 'nullable|string',
            'training_certifications' => 'nullable|string',
            'pir_pirl' => 'nullable|boolean',
            'technical_document' => 'nullable|boolean',
            'crane' => 'nullable|boolean',
            'work_start_declaration' => 'nullable|boolean',
            'scaffolding' => 'nullable|boolean',
            'network_plans' => 'nullable|boolean',
            'degassing_certificate' => 'nullable|boolean',
            'fire_permit' => 'nullable|string',
            'specific_permit' => 'nullable|string',
            'other_permit' => 'nullable|string',
        ]);

        $plans = Plan::create($validated);
         return $this->success($plans, 'Plan created successfully', 200);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
