<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Action;
use App\Models\Product;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\ReadinessForm;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AuditStoreRequest;
use App\Http\Requests\AuditUpdateRequest;

class AuditController extends Controller
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
        $data = $request->validate([
            'date' => 'required|date',
            'lieu' => 'required|string',
            'auditeur' => 'required|string',
            'intervenant' => 'required|string',
            'responses' => 'nullable|array',
            // 'culture_sse' => 'required|in:++,+,-=/,-,--',
            'actions' => 'nullable|array',
        ]);

        // Calculate score based on responses
        $totalScore = 0;
        if ($request->has('responses')) {
            foreach ($request->input('responses') as $response) {
                $note = $response['note'] ?? '';
                switch ($note) {
                    case 'TS':
                        $totalScore += 2;
                        break;
                    case 'S':
                        $totalScore += 1;
                        break;
                    case 'IS':
                        $totalScore -= 1;
                        break;
                    case 'SO':
                        $totalScore += 0;
                        break;
                }
            }
        }

        // Calculate QSER score based on range
        $qserScore = $totalScore;
        if ($qserScore >= 12) {
            $cultureQser = '++';
        } elseif ($qserScore >= 0) {
            $cultureQser = '+';
        } elseif ($qserScore >= -12) {
            $cultureQser = '-';
        } else {
            $cultureQser = '--';
        }

        // Process responses array
        $responses = [];
        if ($request->has('responses')) {
            foreach ($request->input('responses') as $index => $response) {
                if (isset($response['note']) && !empty($response['note'])) {
                    $responses[] = [
                        'question' => $request->input("responses.{$index}.question") ?? "Question {$index}",
                        'note' => $response['note'],
                        'comment' => $response['comment'] ?? '',
                    ];
                }
            }
        }

        // Process actions array
        $actions = $data['actions'] ?? [];

        $audit = Audit::create([
            'date' => $data['date'],
            'lieu' => $data['lieu'],
            'auditeur' => $data['auditeur'],
            'intervenant' => $data['intervenant'],
            'responses' => json_encode($responses),
            'culture_sse' => $cultureQser, // Updated with calculated QSER
            'qser_score' => $qserScore,   // Added QSER score
            'actions' => json_encode($actions),
        ]);

        if ($actions) {
            Action::create([
                'origin' => 'Audit',
                'action_number' => $this->random_number(),
                'description' => 'audit description',
                'issued_date' => now(),
                'pilot_id' => auth()->user()->id ?? 0,
                'deadline' => $actions[0]['delai'] ?? now()->addDays(7),
                'json_data' => json_encode(['audit_id' => $audit->id, 'progress' => 0]),
                'due_date' => now()->addDays(7),
                'progress_rate' => 0,
                'efficiency' => 'N',
                'type' => 'Immediate',
                'comments' => 'Action generated from audit',
            ]);
        } 

        return response()->json([
            'success' => true,
            'message' => 'Audit submitted successfully.',
            'redirect' => route('audit.index'),
        ]);
    }

    function random_number($min = 0, $max = 1000)
    {
        return mt_rand($min, $max);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $audit = Audit::findOrFail($id);
        return view('audits.show', compact('audit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $audit = Audit::findOrFail($id);
        // Decode JSON if it's a string
        if (is_string($audit->responses)) {
            $audit->responses = json_decode($audit->responses, true);
        }
        if (is_string($audit->actions)) {
            $audit->actions = json_decode($audit->actions, true);
        }
        return view('audits.edit', compact('audit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $data = $request->validate([
            'date' => 'required|date',
            'lieu' => 'required|string',
            'auditeur' => 'required|string',
            'intervenant' => 'required|string',
            'responses' => 'nullable|array',
            // 'culture_sse' => 'required|in:++,+,-=/,-,--',
            'actions' => 'nullable|array',
        ]);

        // Find the existing audit record
        $audit = Audit::findOrFail($id);

        // Calculate score based on responses
        $totalScore = 0;
        if ($request->has('responses')) {
            foreach ($request->input('responses') as $response) {
                $note = $response['note'] ?? '';
                switch ($note) {
                    case 'TS':
                        $totalScore += 2;
                        break;
                    case 'S':
                        $totalScore += 1;
                        break;
                    case 'IS':
                        $totalScore -= 1;
                        break;
                    case 'SO':
                        $totalScore += 0;
                        break;
                }
            }
        }

        // Calculate QSER score based on range
        $qserScore = $totalScore;
        if ($qserScore >= 12) {
            $cultureQser = '++';
        } elseif ($qserScore >= 0) {
            $cultureQser = '+';
        } elseif ($qserScore >= -12) {
            $cultureQser = '-';
        } else {
            $cultureQser = '--';
        }

        // Process responses array
        $responses = [];
        if ($request->has('responses')) {
            foreach ($request->input('responses') as $index => $response) {
                if (isset($response['note']) && !empty($response['note'])) {
                    $responses[] = [
                        'question' => $request->input("responses.{$index}.question") ?? "Question {$index}",
                        'note' => $response['note'],
                        'comment' => $response['comment'] ?? '',
                    ];
                }
            }
        }

        // Process actions array
        $actions = $data['actions'] ?? [];

        // Update the audit record
        $audit->update([
            'date' => $data['date'],
            'lieu' => $data['lieu'],
            'auditeur' => $data['auditeur'],
            'intervenant' => $data['intervenant'],
            'responses' => $responses, // Laravel will JSON encode due to $casts
            'culture_sse' => $cultureQser, // Updated with calculated QSER
            'qser_score' => $qserScore,   // Updated QSER score
            'actions' => $actions,        // Laravel will JSON encode due to $casts
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Audit updated successfully.',
            'redirect' => route('audit.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $audit = Audit::FindOrFail($id);
        $audit->delete();
        return $this->success('Audit Delete Successfully', ['success' => true, 'data' => null]);
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
