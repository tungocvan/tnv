<?php

namespace Modules\Admission\Livewire\Public;

use Livewire\Component;
use Modules\Admission\Models\AdmissionLocation;
use Modules\Admission\Models\AdmissionCatalog;
use Modules\Admission\Services\AdmissionService;

class RegistrationForm extends Component
{
    public $currentStep = 1;
    public $totalSteps = 5;

    // Danh sách đổ bộ từ DB
    public $provinces = [];
    public $tt_wards = [];
    public $ht_wards = [];
    public $ethnicities = [];
    public $religions = [];

    public $form = [
        // Bước 1: Thông tin định danh 
        'HoVaTenHocSinh' => '', 'GioiTinh' => '', 'NgaySinh' => '', 'DanToc' => 'Kinh', 
        'MaDinhDanh' => '', 'QuocTich' => 'Việt Nam', 'TonGiao' => 'Không', 'SDTEnetViet' => '', 
        'NoiSinh' => '', 'NoiDangKyKhaiSinh' => '', 'QueQuan' => '',

        // Bước 2: Địa chỉ 
        'TTSN' => '', 'TTD' => '', 'TTKP' => '', 'TTPX' => '', 'TTTTP' => '', 'DiaChiThuongTru' => '',
        'HTSN' => '', 'HTD' => '', 'HTKP' => '', 'HTPX' => '', 'HTTTP' => '', 'NoiOHienTai' => '',

        // Bước 3: Thông tin bổ sung 
        'OChungVoi' => '', 'QuanHeNguoiNuoiDuong' => '', 'ConThu' => '', 'TSAnhChiEm' => '', 
        'HoanThanhLopLa' => '', 'TruongMamNon' => '', 'KhaNangHocSinh' => '', 'SucKhoeCanLuuY' => '',

        // Bước 4: Thông tin Phụ huynh 
        'HoTenCha' => '', 'NamSinhCha' => '', 'TdvhCha' => '', 'TdcmCha' => '', 'NgheNghiepCha' => '', 'ChucVuCha' => '', 'DienThoaiCha' => '', 'CCCDCha' => '',
        'HoTenMe' => '', 'NamSinhMe' => '', 'TdvhMe' => '', 'TdcmMe' => '', 'NgheNghiepMe' => '', 'ChucVuMe' => '', 'DienThoaiMe' => '', 'CCCDMe' => '',
        'HoTenNguoiGiamHo' => '', 'QuanHeGiamHo' => '', 'DienThoaiGiamHo' => '', 'CCCDGiamHo' => '',

        // Bước 5: Đăng ký & Cam kết 
        'AnhChiRuotTrongTruong' => '', 'ThanhPhanGiaDinh' => '', 'LoaiLopDangKy' => '', 
        'CK_GocHocTap' => false, 'CK_SachVo' => false, 'CK_HopPH' => false, 'CK_ThamGiaHD' => false, 'CK_GanGui' => false,
        'NgayLamDon' => '', 'NguoiLamDon' => ''
    ];

    public function mount() {
        $this->provinces = AdmissionLocation::select('province_name')->distinct()->get()->toArray();
        $this->ethnicities = AdmissionCatalog::where('type', 'ethnicity')->get()->toArray();
        $this->religions = AdmissionCatalog::where('type', 'religion')->get()->toArray();
        $this->form['NgayLamDon'] = date('d/m/Y');
    }

    public function updated($propertyName) {
        if ($propertyName === 'form.TTTTP') {
            $this->tt_wards = AdmissionLocation::where('province_name', $this->form['TTTTP'])->get()->toArray();
        }
        if ($propertyName === 'form.HTTTP') {
            $this->ht_wards = AdmissionLocation::where('province_name', $this->form['HTTTP'])->get()->toArray();
        }
        // Tự động nối chuỗi địa chỉ chi tiết
        $this->form['DiaChiThuongTru'] = "{$this->form['TTSN']} {$this->form['TTD']}, {$this->form['TTKP']}, {$this->form['TTPX']}, {$this->form['TTTTP']}";
        $this->form['NoiOHienTai'] = "{$this->form['HTSN']} {$this->form['HTD']}, {$this->form['HTKP']}, {$this->form['HTPX']}, {$this->form['HTTTP']}";
    }

    public function nextStep() { $this->currentStep++; }
    public function prevStep() { $this->currentStep--; }

   
    public function save(AdmissionService $service)
    {
        // Validate trước khi lưu (tùy chọn)
        $this->validate([
            'form.HoVaTenHocSinh' => 'required',
            'form.MaDinhDanh' => 'required|digits:12',
        ]);

        // Gọi service
        $application = $service->createRegistration($this->form);

        // Chuyển hướng sang trang PDF
        return redirect()->route('admission.download-pdf', ['id' => $application->id]);
    }
    public function render() { return view('Admission::livewire.public.registration-form'); }
}