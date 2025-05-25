<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ReadinessForm;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AuditStoreRequest;
use App\Http\Requests\AuditUpdateRequest;

class AuditController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        //KEY : MULTIPERMISSION
        $this->middleware('permission:audit-list|audit-create|audit-edit|audit-show|audit-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:audit-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:audit-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:audit-delete', ['only' => ['destroy']]);
        $this->middleware('permission:audit-show', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audits = Audit::latest()->get();
        return view('audits.index', compact('audits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('audits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'date' => 'required|date',
            'intervenant' => 'required|string',
            'themes_comments' => 'nullable|string',
            'mission_comments' => 'nullable|string',
            'trainings_comments' => 'nullable|string',
            'authorizations_comments' => 'nullable|string',
            'env_risks_comments' => 'nullable|string',
            'sse_comments' => 'nullable|string',
            'actions' => 'nullable|array',
        ]);

        // Generate actions for immediate risks
        $actions = $data['actions'] ?? [];
        if ($data['risks_score'] === 'SO' || $data['sse_score'] <= 2) {
            $actions[] = [
                'description' => 'Address immediate risks identified',
                'responsible' => 'RQSE Team',
                'deadline' => now()->addDays(3)->toDateString(),
                'type' => 'I',
            ];
        }

        $audit = Audit::create([
            'date' => $data['date'],
            'site' => $data['site'],
            'auditor' => $data['auditor'],
            'intervenant' => $data['intervenant'],
            'themes_comments' => $data['themes_comments'],
            'mission_score' => $data['mission_score'],
            'mission_comments' => $data['mission_comments'],
            'risks_score' => $data['risks_score'],
            'risks_comments' => $data['risks_comments'],
            'trainings_score' => $data['trainings_score'],
            'trainings_comments' => $data['trainings_comments'],
            'authorizations_score' => $data['authorizations_score'],
            'authorizations_comments' => $data['authorizations_comments'],
            'env_risks_score' => $data['env_risks_score'],
            'env_risks_comments' => $data['env_risks_comments'],
            'access_score' => $data['access_score'],
            'access_comments' => $data['access_comments'],
            'safety_score' => $data['safety_score'],
            'safety_comments' => $data['safety_comments'],
            'mase_score' => $data['mase_score'],
            'mase_comments' => $data['mase_comments'],
            'prevention_score' => $data['prevention_score'],
            'prevention_comments' => $data['prevention_comments'],
            'client_expectations_score' => $data['client_expectations_score'],
            'client_expectations_comments' => $data['client_expectations_comments'],
            'feedback_score' => $data['feedback_score'],
            'feedback_comments' => $data['feedback_comments'],
            'last_causerie_score' => $data['last_causerie_score'],
            'last_causerie_comments' => $data['last_causerie_comments'],
            'sse_score' => $data['sse_score'],
            'sse_comments' => $data['sse_comments'],
            'actions' => json_encode($actions),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Audit submitted successfully.',
            'redirect' => route('dashboard'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->with('getParentCatHasOne')->where('user_id', auth()->user()->id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $parent_category = Category::where('status', Category::STATUS_ACTIVE)->get();
        //$subCategories = SubCategory::where('status', SubCategory::STATUS_ACTIVE)->get();
        return view('products.edit', compact('product', 'parent_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AuditUpdateRequest $request, Product $product)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

    }

    /**
     * _singleFileUploads : Complete Fileupload Handling
     * @param  Request $request
     * @param  $htmlformfilename : input type file name
     * @param  $uploadfiletopath : Public folder paths 'foldername/subfoldername' Example public/user
     * @return File save with array return
     */
    private function _singleFileUploads($request = "", $htmlformfilename = "", $uploadfiletopath = "")
    {
        try {
            // check parameter empty Validation
            if (empty($request) || empty($htmlformfilename) || empty($uploadfiletopath)) {
                throw new \Exception("Required Parameters are missing", 400);
            }
            // check if folder exist at public directory if not exist then create folder 0777 permission
            if (!file_exists($uploadfiletopath)) {
                $oldmask = umask(0);
                mkdir($uploadfiletopath, 0777, true);
                umask($oldmask);
            }
            $fileNameOnly = preg_replace("/[^a-z0-9\_\-]/i", '', basename($request->file($htmlformfilename)->getClientOriginalName(), '.' . $request->file($htmlformfilename)->getClientOriginalExtension()));
            $fileFullName = $fileNameOnly . "_" . date('dmY') . "_" . time() . "." . $request->file($htmlformfilename)->getClientOriginalExtension();
            $path = $request->file($htmlformfilename)->storeAs($uploadfiletopath, $fileFullName);
            // $request->file($htmlformfilename)->move(public_path($uploadfiletopath), $fileFullName);
            $resp['status'] = true;
            $resp['data'] = array('name' => $fileFullName, 'url' => url('storage/' . str_replace('public/', '', $uploadfiletopath) . '/' . $fileFullName), 'path' => \storage_path('app/' . $path), 'extenstion' => $request->file($htmlformfilename)->getClientOriginalExtension(), 'type' => $request->file($htmlformfilename)->getMimeType(), 'size' => $request->file($htmlformfilename)->getSize());
            $resp['message'] = "File uploaded successfully..!";
        } catch (\Exception $ex) {
            $resp['status'] = false;
            $resp['data'] = ['name' => null];
            $resp['message'] = 'File not uploaded...!';
            $resp['ex_message'] = $ex->getMessage();
            $resp['ex_code'] = $ex->getCode();
            $resp['ex_file'] = $ex->getFile();
            $resp['ex_line'] = $ex->getLine();
        }
        return $resp;
    }
}
