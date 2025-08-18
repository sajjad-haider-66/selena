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
        $this->middleware('permission:Liste des audits|Créer un audit|Modifier un audit|Voir un audit|Supprimer un audit', ['only' => ['index', 'store']]);
        $this->middleware('permission:Créer un audit', ['only' => ['create', 'store']]);
        $this->middleware('permission:Modifier un audit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Supprimer un audit', ['only' => ['destroy']]);
        $this->middleware('permission:Voir un audit', ['only' => ['show']]);
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
            'culture_sse_level_hidden' => 'nullable|string',
            'culture_sse_hidden' => 'nullable|string',
            'actions' => 'nullable|array',
        ]);

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
            'culture_sse' => $data['culture_sse_level_hidden'], // Updated with calculated QSER
            'qser_score' => $data['culture_sse_hidden'],   // Added QSER score
            'actions' => json_encode($actions),
        ]);

        if ($actions) {
            Action::create([
                'origin' => 'Audit',
                'origin_view_id' => $audit->id,
                'action_origin' => 'audit',
                'action_number' => $this->random_number(),
                'description' => $actions[0]['description'] ??'audit description',
                'issued_date' => now(),
                'emission' => now(),
                'pilot_id' => $actions[0]['responsable'] ?? auth()->user()->id,
                'due_date' => $actions[0]['delai'] ?? now()->addDays(7),
                'json_data' => json_encode(['audit_id' => $audit->id, 'progress' => 0]),
                'progress_rate' => 0,
                'efficiency' => 'N',
                'type' => $actions[0]['type'] ?? now()->addDays(7),
                'comments' => 'Action générée par l audit',
            ]);
        } 

        return response()->json([
            'success' => true,
            'message' => 'Audit soumis avec succès.',
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
            'culture_sse_level_hidden' => 'nullable|string',
            'culture_sse_hidden' => 'nullable|string',
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
            'culture_sse' => $data['culture_sse_level_hidden'], // Updated with calculated QSER
            'qser_score' => $data['culture_sse_hidden'],   // Added QSER score
            'actions' => $actions,        // Laravel will JSON encode due to $casts
        ]);

        if ($actions) {
            $action = Action::where('action_origin', 'audit')
                ->where('origin_view_id', $audit->id)
                ->first();

            if ($action) {
                $action->update([
                    'origin'         => 'Audit',                      // same as create
                    'origin_view_id' => $audit->id,                  // same as create
                    'action_origin'  => 'audit',                     // missing key fixed
                    'action_number'  => $action->action_number 
                                    ?? $this->random_number(),    // keep existing number; no regen
                    'description'    => $actions[0]['description'] 
                                    ?? 'audit description',
                    'issued_date'    => now(),
                    'emission'       => now(),
                    'pilot_id'       => $actions[0]['responsable'] 
                                    ?? auth()->user()->id,
                    'due_date'       => $actions[0]['delai'] 
                                    ?? now()->addDays(7),
                    'json_data'      => json_encode(['audit_id' => $audit->id, 'progress' => 0]),
                    'progress_rate'  => 0,
                    'efficiency'     => 'N',
                    'type'           => $actions[0]['type'] 
                                    ?? $action->type,             // date ki jagah existing type
                    'comments'       => 'Action générée par l audit',
                ]);
            }
        }


        return response()->json([
            'success' => true,
            'message' => 'Audit mis à jour avec succès.',
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
        // Check if related action exists
        $delAction = Action::where('origin_view_id', $id)
            ->where('action_origin', 'audit')
            ->first();

        if ($delAction) {
            $delAction->delete();
        }
        return $this->success('Audit supprimé avec succès', ['success' => true, 'data' => null]);
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
                throw new \Exception("Les paramètres obligatoires sont manquants", 400);
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
            $resp['message'] = "Fichier téléchargé avec succès.!";
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
