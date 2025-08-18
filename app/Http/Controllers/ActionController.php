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
use App\Traits\ApiResponse;

class ActionController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {  //KEY : MULTIPERMISSION
        $this->middleware('permission:Liste des actions|Créer une action|Modifier une action|Voir une action|Supprimer une action', ['only' => ['index', 'store']]);
        $this->middleware('permission:Créer une action', ['only' => ['create', 'store']]);
        $this->middleware('permission:Modifier une action', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Supprimer une action', ['only' => ['destroy']]);
        $this->middleware('permission:Voir une action', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actions = Action::orderBy('updated_at', 'desc')->get();
        $averageProgress = $actions->count() > 0 ? $actions->avg('progress_rate') : 0;
        $progress = round($averageProgress, 2);
        return view('actions.index', compact('actions', 'progress'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $products = Product::where('status', Product::STATUS_ACTIVE)->get();
        return view('actions.create');
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        // dd($request->all());
         $request->validate([
            'action_number' => 'required',
         ]);
       

        $action = Action::create([
            'action_number' =>  $request->action_number,
            'origin' =>  $request->origin,
            'issue_description' =>  $request->issue_description,
            'start_date' =>  $request->issue_date,
            'description' =>  $request->description,
            'type' =>  $request->type,
            'pilot_id' =>  $request->pilot,
            'due_date' =>  $request->deadline,
            'verifier_id' =>  $request->verifier,
            'verified_date' =>  $request->verified_date,
            'comments' =>  $request->comment,
            'progress_rate' =>  $request->progress_percentage,
            'efficiency' =>  $request->effectiveness,
            'emission' => now(),
        ]);

        return $this->success('Action créée avec succès', ['success' => true, 'data' => null]);
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

    public function indexStore(Request $request, $id)
    {
        // Validate the request data
        $action = Action::findOrFail($id);

        // Check if the action exists
        if (!$action) {
            return $this->error('Action not found', 404);
        }
    
        // Update the action with the provided data
        $action->update([
            'start_date' => $request->start_on, // Foreign key or reference ID
            'end_date' => $request->finished_on,
            'auditor' => $request->auditor,
            'checked_on' => $request->checked_on,
            'comments' => $request->comments,
        ]); 

        // Calculate and save progress rate
        $action->calculateProgressRate();
        
        // Return a success response
        return $this->success('Action mise à jour avec succès', ['success' => true, 'data' => null]);
    }

}
