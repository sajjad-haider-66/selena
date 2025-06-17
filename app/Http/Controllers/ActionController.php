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
        $action = Action::where('pilot_id', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        return view('actions.index', compact('action'));
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
        // $jsonData = [
        //     'origin' => $request->input('origin', []),
        //     'actions' => $request->input('actions', []),
        // ];

        // if ($request->filled('new_action_date')) {
        //     $jsonData['actions'][] = array_filter([
        //         'issued_date' => $request->input('new_action_date'),
        //         'description' => $request->input('new_action_description'),
        //         'i' => $request->input('new_action_i'),
        //         'c' => $request->input('new_action_c'),
        //         'p' => $request->input('new_action_p'),
        //         'pilot' => $request->input('new_action_pilot'),
        //         'deadline' => $request->input('new_action_deadline'),
        //         'start_date' => $request->input('new_action_started'),
        //         'end_date' => $request->input('new_action_completed'),
        //         'verifier' => $request->input('new_action_verifier'),
        //         'verified_date' => $request->input('new_action_verified'),
        //         'progress_rate' => $request->input('new_action_progress'),
        //         'efficiency' => $request->input('new_action_efficiency'),
        //         'comment' => $request->input('new_action_comment'),
        //     ]);
        // }

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
        ]);

        return $this->success('Action Created Successfully', ['success' => true, 'data' => null]);
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
