<?php

namespace Modules\Admission\Livewire\Public;

use Livewire\Component;
use Modules\Admission\Models\AdmissionLocation;
use Modules\Admission\Models\AdmissionCatalog;
use Modules\Admission\Services\AdmissionService;
use Illuminate\Support\Facades\Log;

class RegistrationForm extends Component
{
    public $currentStep = 1;
    public $totalSteps = 5;

    public $provinces = [];
    public $tt_wards = [];
    public $ht_wards = [];
    public $ethnicities = [];
    public $religions = [];

    public $form = [
        'HoVaTenHocSinh' => '', 'GioiTinh' => '', 'NgaySinh' => '', 'DanToc' => 'Kinh',
        'MaDinhDanh' => '', 'QuocTich' => 'Việt Nam', 'TonGiao' => 'Không', 'SDTEnetViet' => '',
        'NoiSinh' => '', 'NoiDangKyKhaiSinh' => '', 'QueQuan' => '',
        'TTSN' => '', 'TTD' => '', 'TTKP' => '', 'TTPX' => '', 'TTTTP' => '', 'DiaChiThuongTru' => '',
        'HTSN' => '', 'HTD' => '', 'HTKP' => '', 'HTPX' => '', 'HTTTP' => '', 'NoiOHienTai' => '',
        'OChungVoi' => '', 'QuanHeNguoiNuoiDuong' => '', 'ConThu' => '', 'TSAnhChiEm' => '',
        'HoanThanhLopLa' => '', 'TruongMamNon' => '', 'KhaNangHocSinh' => '', 'SucKhoeCanLuuY' => '',
        'HoTenCha' => '', 'NamSinhCha' => '', 'TdvhCha' => '', 'TdcmCha' => '', 'NgheNghiepCha' => '', 'ChucVuCha' => '', 'DienThoaiCha' => '', 'CCCDCha' => '',
        'HoTenMe' => '', 'NamSinhMe' => '', 'TdvhMe' => '', 'TdcmMe' => '', 'NgheNghiepMe' => '', 'ChucVuMe' => '', 'DienThoaiMe' => '', 'CCCDMe' => '',
        'HoTenNguoiGiamHo' => '', 'QuanHeGiamHo' => '', 'DienThoaiGiamHo' => '', 'CCCDGiamHo' => '',
        'AnhChiRuotTrongTruong' => '', 'ThanhPhanGiaDinh' => '', 'LoaiLopDangKy' => '',
        'CK_GocHocTap' => false, 'CK_SachVo' => false, 'CK_HopPH' => false, 'CK_ThamGiaHD' => false, 'CK_GanGui' => false,
        'NgayLamDon' => '', 'NguoiLamDon' => ''
    ];

    protected $rules = [
        'form.HoVaTenHocSinh' => 'required|min:5',
        'form.MaDinhDanh' => 'required|digits:12', // Phải đúng 12 số
        'form.LoaiLopDangKy' => 'required',
        'form.NguoiLamDon' => 'required',
    ];

    protected $messages = [
        'form.HoVaTenHocSinh.required' => 'Vui lòng nhập họ tên học sinh.',
        'form.MaDinhDanh.required' => 'Mã định danh là bắt buộc.',
        'form.MaDinhDanh.digits' => 'Mã định danh phải chính xác 12 chữ số.',
        'form.LoaiLopDangKy.required' => 'Vui lòng chọn lớp đăng ký.',
        'form.NguoiLamDon.required' => 'Vui lòng nhập tên người làm đơn.',
    ];

    public function mount() {
        $this->provinces = AdmissionLocation::select('province_name')->distinct()->get()->toArray();
        $this->ethnicities = AdmissionCatalog::where('type', 'ethnicity')->get()->toArray();
        $this->religions = AdmissionCatalog::where('type', 'religion')->get()->toArray();
        $this->form['NgayLamDon'] = date('Y-m-d');
    }

    public function updated($propertyName) {
        if ($propertyName === 'form.TTTTP') {
            $this->tt_wards = AdmissionLocation::where('province_name', $this->form['TTTTP'])->get()->toArray();
        }
        if ($propertyName === 'form.HTTTP') {
            $this->ht_wards = AdmissionLocation::where('province_name', $this->form['HTTTP'])->get()->toArray();
        }
    }

    public function nextStep() {
        // Có thể thêm validation theo từng bước ở đây
        $this->currentStep++;
    }

    public function prevStep() { $this->currentStep--; }

    public function save(AdmissionService $service)
    {

        $this->validate();

        try {
            // Lưu dữ liệu
            $application = $service->createRegistration($this->form);

            // Kiểm tra nếu lưu thành công thì mới redirect
            if ($application && $application->id) {
                //return redirect()->route('admission.download-pdf', ['id' => $application->id]);
                return redirect()->route('admission.download-word', ['id' => $application->id]);
            }
        } catch (\Exception $e) {
            Log::error("Lỗi lưu đơn: " . $e->getMessage());
            session()->flash('error', 'Có lỗi xảy ra trong quá trình lưu dữ liệu.');
        }
    }

    public function render() { return view('Admission::livewire.public.registration-form'); }
}
