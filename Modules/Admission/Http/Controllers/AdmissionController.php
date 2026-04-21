<?php

namespace Modules\Admission\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admission\Services\AdmissionService;
use Modules\Admission\Models\AdmissionApplication;
use Barryvdh\DomPDF\Facade\Pdf;

class AdmissionController extends Controller
{
    protected $admissionService;

    public function __construct(AdmissionService $admissionService)
    {
        $this->admissionService = $admissionService;
    }

    /**
     * Giao diện đăng ký dành cho Phụ huynh (Sử dụng Livewire Component)
     */
    public function index()
    {
        return view('Admission::pages.public.register');
    }

    /**
     * Giao diện quản lý danh sách đơn (Admin CRUD)
     */
    public function adminIndex()
    {
        return view('Admission::pages.admin.index');
    }

    /**
     * Giao diện chỉnh sửa đơn (Admin CRUD)
     */
    public function adminEdit($id)
    {
        $application = AdmissionApplication::findOrFail($id);
        return view('Admission::pages.admin.edit', compact('application'));
    }

    /**
     * XỬ LÝ XUẤT PDF - TRẢ VỀ FILE GIỐNG WORD
     */
    public function downloadPdf($id)
    {
        // 1. Lấy Full Data đã được mapping từ Service
        $data = $this->admissionService->getDataForPdf($id);

        // 2. Load View PDF (Template này sẽ thiết kế giống file Word của bạn)
        $pdf = Pdf::loadView('Admission::pdf.registration', $data)
                  ->setPaper('a4', 'portrait')
                  ->setWarnings(false);

        // 3. Đặt tên file: Don_Dang_Ky_HoTen_MHS.pdf
        $fileName = 'Don_Dang_Ky_' . str_replace(' ', '_', $data['HoVaTenHocSinh']) . '_' . $data['MHS'] . '.pdf';

        // 4. Trả về trình duyệt để tự động tải xuống
        return $pdf->download($fileName);
    }
}