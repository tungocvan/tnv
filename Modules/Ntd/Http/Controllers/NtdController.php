<?php

namespace Modules\Ntd\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Ntd\Models\Application;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
// use Illuminate\Http\Request;

class NtdController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:ntd-list|ntd-create|ntd-edit|ntd-delete', ['only' => ['index','show']]);
        // $this->middleware('permission:ntd-create', ['only' => ['create','store']]);
        // $this->middleware('permission:ntd-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:ntd-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('Ntd::pages.index');
    }
    public function list()
    {
        return view('Ntd::pages.admin.applications.list');
    }

    // ======================
    // SHOW PAGE
    // ======================
    public function show($id)
    {
        return view('Ntd::pages.admin.applications.show', compact('id'));
    }

    // ======================
    // PREVIEW PDF (open tab)
    // ======================
    public function preview($id)
    {
        $application = Application::with('student')->findOrFail($id);

        $pdf = Pdf::loadView('Ntd::pdf.application', compact('application'));

        return $pdf->stream('preview.pdf');
    }

    // ======================
    // EXPORT PDF (download)
    // ======================


  
public function export($id)
{
    // ======================
    // LOAD DATA
    // ======================
    $application = Application::with('student')->findOrFail($id);
    $student = $application->student;

    // ======================
    // CREATE TEMP FOLDER
    // ======================
    $tempPath = storage_path('app/temp');

    if (!File::exists($tempPath)) {
        File::makeDirectory($tempPath, 0755, true);
    }

    // ======================
    // LOAD TEMPLATE
    // ======================
    $templateProcessorClass = 'PhpOffice\\PhpWord\\TemplateProcessor';
    $template = new $templateProcessorClass(storage_path('app/templates/application.docx'));
   
    // ======================
    // HELPER FORMAT
    // ======================
    $formatDate = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d/m/Y') : '';
    $formatGender = fn($g) => $g === 0 || $g === 'male' ? 'Nam' : ($g === 1 || $g === 'female' ? 'Nữ' : '');
    $formatBool = fn($v) => $v ? 'Có' : 'Không';

    // ======================
    // BUILD MAP (62 FIELDS)
    // ======================
    $data = [

        // ===== BASIC =====
        'code' => $application->code,
        'full_name' => $student?->full_name,
        'date_of_birth' => $formatDate($student?->date_of_birth),
        'gender' => $formatGender($student?->gender),
        'ethnicity' => data_get($application, 'ethnicity'),
        'identity_number' => $student?->identity_number,
        'religion' => data_get($application, 'religion'),
        'nationality' => data_get($application, 'nationality'),

        // ===== HOMETOWN =====
        'hometown_ward' => data_get($application, 'hometown.ward'),
        'hometown_province' => data_get($application, 'hometown.province'),
        'hometown_detail' => data_get($application, 'hometown.detail'),

        // ===== BIRTH PLACE =====
        'birth_place_ward' => data_get($application, 'birth_place.ward'),
        'birth_place_province' => data_get($application, 'birth_place.province'),
        'birth_place_detail' => data_get($application, 'birth_place.detail'),

        // ===== BIRTH CERT =====
        'birth_cert_place_ward' => data_get($application, 'birth_cert_place.ward'),
        'birth_cert_place_province' => data_get($application, 'birth_cert_place.province'),
        'birth_cert_place_detail' => data_get($application, 'birth_cert_place.detail'),

        // ===== ADDRESS =====
        'permanent_house' => data_get($application, 'addresses.permanent.house_number'),
        'permanent_street' => data_get($application, 'addresses.permanent.street'),
        'permanent_district' => data_get($application, 'addresses.permanent.district'),
        'permanent_ward' => data_get($application, 'addresses.permanent.ward'),
        'permanent_province' => data_get($application, 'addresses.permanent.province'),

        'current_house' => data_get($application, 'addresses.current.house_number'),
        'current_street' => data_get($application, 'addresses.current.street'),
        'current_district' => data_get($application, 'addresses.current.district'),
        'current_ward' => data_get($application, 'addresses.current.ward'),
        'current_province' => data_get($application, 'addresses.current.province'),

        // ===== OTHER =====
        'enetviet_phone' => $student?->phone,
        'is_mg5' => $formatBool(data_get($application, 'is_mg5')),

        // ===== FATHER =====
        'father_name' => data_get($application, 'family_info.father.name'),
        'father_birth_year' => data_get($application, 'family_info.father.birth_year'),
        'father_job' => data_get($application, 'family_info.father.job'),
        'father_phone' => data_get($application, 'family_info.father.phone'),
        'father_id' => data_get($application, 'family_info.father.identity'),

        // ===== MOTHER =====
        'mother_name' => data_get($application, 'family_info.mother.name'),
        'mother_birth_year' => data_get($application, 'family_info.mother.birth_year'),
        'mother_job' => data_get($application, 'family_info.mother.job'),
        'mother_phone' => data_get($application, 'family_info.mother.phone'),
        'mother_id' => data_get($application, 'family_info.mother.identity'),

        // ===== GUARDIAN =====
        'guardian_name' => data_get($application, 'family_info.guardian.name'),
        'guardian_birth_year' => data_get($application, 'family_info.guardian.birth_year'),
        'guardian_job' => data_get($application, 'family_info.guardian.job'),
        'guardian_phone' => data_get($application, 'family_info.guardian.phone'),
        'guardian_id' => data_get($application, 'family_info.guardian.identity'),

        // ===== CLASS =====
        'class_type' => data_get($application, 'registration.class_type'),

        // ===== EXTRA FLAGS =====
        'toan_khoa' => data_get($application, 'registration.toan_khoa'),
        'tath' => data_get($application, 'registration.tath'),
        'tang_cuong' => data_get($application, 'registration.tang_cuong'),

        // ===== SIBLINGS 1 =====
        'sibling_name_1' => data_get($application, 'siblings.0.name'),
        'sibling_birth_year_1' => data_get($application, 'siblings.0.birth_year'),
        'sibling_school_1' => data_get($application, 'siblings.0.school'),

        // ===== SIBLINGS 2 =====
        'sibling_name_2' => data_get($application, 'siblings.1.name'),
        'sibling_birth_year_2' => data_get($application, 'siblings.1.birth_year'),
        'sibling_school_2' => data_get($application, 'siblings.1.school'),

        // ===== HEALTH =====
        'health_status' => data_get($application, 'health_info.status'),
        'health_note' => data_get($application, 'health_info.note'),

        // ===== ABILITY =====
        'ability' => data_get($application, 'abilities'),

        // ===== NOTE =====
        'special_note' => data_get($application, 'note'),

        // ===== COMMITMENT =====
        'commitment' => data_get($application, 'commitment'),

        // ===== TIME =====
        'created_at' => optional($application->created_at)->format('d/m/Y'),
        'updated_at' => optional($application->updated_at)->format('d/m/Y'),
    ];

    // ======================
    // AUTO MAP
    // ======================
    foreach ($data as $key => $value) {
        $template->setValue($key, $value ?? '');
    }

    // ======================
    // SAVE FILE
    // ======================
    $docxPath = $tempPath . "/application_{$application->id}.docx";
    $template->saveAs($docxPath);

   
    $pdfPath  = $tempPath . "/application_{$application->id}.pdf";
     // ======================
    // CONVERT DOCX → PDF 
    // apt update && apt install -y libreoffice
    // ======================
    $process = new Process([
        'libreoffice',
        '--headless',
        '--convert-to',
        'pdf',
        '--outdir',
        $tempPath,
        $docxPath
    ]);

    // 🔥 FIX QUAN TRỌNG
    $process->setEnv([
        'HOME' => storage_path('app/temp'),
    ]);

    $process->run();

    // ======================
    // ERROR HANDLE
    // ======================
    if (!$process->isSuccessful()) {
        throw new \Exception('Convert PDF failed: ' . $process->getErrorOutput());
    }

    // ======================
    // RETURN FILE
    // ======================
    return response()->download($pdfPath)->deleteFileAfterSend(true);
}
}
