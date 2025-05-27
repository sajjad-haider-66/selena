<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Action;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderProductPivot;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ActionUpdateRequest;

class ActionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {  //KEY : MULTIPERMISSION
        $this->middleware('permission:action-list|action-create|action-edit|action-show|action-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:action-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:action-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:action-delete', ['only' => ['destroy']]);
        $this->middleware('permission:action-show', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actions = Action::where('pilot_id', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        return view('actions.index', compact('actions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('status', Product::STATUS_ACTIVE)->get();
        return view('actions.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'origin.*.mase' => 'nullable|boolean',
            'origin.*.direction' => 'nullable|boolean',
            'origin.*.verifications' => 'nullable|boolean',
            'origin.*.document' => 'nullable|boolean',
            'origin.*.audits' => 'nullable|boolean',
            'origin.*.accident' => 'nullable|boolean',
            'origin.*.incident' => 'nullable|boolean',
            'origin.*.animations' => 'nullable|boolean',
            'origin.*.demandes' => 'nullable|boolean',
            'origin.*.communication' => 'nullable|boolean',
            'origin.*.veille' => 'nullable|boolean',
            'origin.*.comite' => 'nullable|boolean',
            'new_action_number' => 'required_if:origin.new_action_number,null|string',
            'new_description' => 'required_if:origin.new_description,null|string',
            'new_date' => 'required_if:origin.new_date,null|date',
            'actions.*.i' => 'nullable|boolean',
            'actions.*.c' => 'nullable|boolean',
            'actions.*.p' => 'nullable|boolean',
            'new_action_date' => 'required_if:actions.new_action_date,null|date',
            'new_action_description' => 'required_if:actions.new_action_description,null|string',
            'new_action_pilot' => 'required_if:actions.new_action_pilot,null|string',
            'new_action_deadline' => 'required_if:actions.new_action_deadline,null|date',
            'new_action_progress' => 'required_if:actions.new_action_progress,null|integer|min:0|max:100',
        ]);

        $jsonData = [
            'origin' => $request->input('origin', []),
            'actions' => $request->input('actions', []),
        ];

        // Handle new action row
        if ($request->filled('new_action_number')) {
            $jsonData['origin'][] = array_filter([
                'mase' => $request->input('new_origin.mase'),
                'direction' => $request->input('new_origin.direction'),
                'verifications' => $request->input('new_origin.verifications'),
                'document' => $request->input('new_origin.document'),
                'audits' => $request->input('new_origin.audits'),
                'accident' => $request->input('new_origin.accident'),
                'incident' => $request->input('new_origin.incident'),
                'animations' => $request->input('new_origin.animations'),
                'demandes' => $request->input('new_origin.demandes'),
                'communication' => $request->input('new_origin.communication'),
                'veille' => $request->input('new_origin.veille'),
                'comite' => $request->input('new_origin.comite'),
                'description' => $request->input('new_description'),
                'issued_date' => $request->input('new_date'),
            ]);
        }

        if ($request->filled('new_action_date')) {
            $jsonData['actions'][] = array_filter([
                'issued_date' => $request->input('new_action_date'),
                'description' => $request->input('new_action_description'),
                'i' => $request->input('new_action_i'),
                'c' => $request->input('new_action_c'),
                'p' => $request->input('new_action_p'),
                'pilot' => $request->input('new_action_pilot'),
                'deadline' => $request->input('new_action_deadline'),
                'start_date' => $request->input('new_action_started'),
                'end_date' => $request->input('new_action_completed'),
                'verifier' => $request->input('new_action_verifier'),
                'verified_date' => $request->input('new_action_verified'),
                'progress_rate' => $request->input('new_action_progress'),
                'efficiency' => $request->input('new_action_efficiency'),
                'comment' => $request->input('new_action_comment'),
            ]);
        }

        $action = Action::create([
            'origin' => 'SSE Action', // Default origin
            'origin_id' => 1, // Default origin_id (can be dynamic)
            'description' => $jsonData['actions'][0]['description'] ?? 'No description',
            'issued_date' => $jsonData['actions'][0]['issued_date'] ?? now(),
            'type' => $this->getActionType($jsonData['actions'][0]),
            'responsible_id' => Auth::id(),
            'json_data' => json_encode($jsonData),
        ]);

        return redirect()->back()->with('success', 'Actions saved successfully.');
    }

    private function getActionType($actionData)
    {
        if ($actionData['i']) return 'Immediate';
        if ($actionData['c']) return 'Corrective';
        if ($actionData['p']) return 'Preventive';
        return 'Preventive';
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $selectedProducts = [];
        $orderId = $order->id;
        $order->with('products')->where('user_id', auth()->user()->id);
        if ($order->has('products')) {
            $order->products->each(function ($prod, $key) use (&$selectedProducts) {
                $selectedProducts[] = $prod->id;
            });
        }
        $products = Product::with(['getParentCatHasOne'])->where('status', Product::STATUS_ACTIVE)->get();
        return view('orders.show', compact('order', 'products', 'selectedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $selectedProducts = [];
        $order->with('products')->where('user_id', auth()->user()->id);
        if ($order->has('products')) {
            $order->products->each(function ($prod) use (&$selectedProducts) {
                $selectedProducts[] = $prod->id;
            });
        }
        $products = Product::where('status', Product::STATUS_ACTIVE)->get();
        return view('orders.edit', compact('order', 'products', 'selectedProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActionUpdateRequest $request, Order $order)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {

    }

}
