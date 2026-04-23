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

    public $provinces = [];
    public $tt_wards = [];
    public $ht_wards = [];
    public $ethnicities = [];
    public $religions = [];
    public $copyNoiSinhToQueQuan = false;
    public $sameAddress = false;

    // ⚠️ QUAN TRỌNG: GIỮ NGUYÊN KEY PascalCase
    public $form = [

        // STEP 1
        'HoVaTenHocSinh' => '',
        'GioiTinh' => '',
        'NgaySinh' => '',
        'DanToc' => 'Kinh',
        'MaDinhDanh' => '',
        'QuocTich' => 'Việt Nam',
        'TonGiao' => 'Không',
        'SDTEnetViet' => '',
        'NoiSinh' => '',
        'NoiDangKyKhaiSinh' => '',
        'QueQuan' => '',

        // STEP 2
        'TTSN' => '',
        'TTD' => '',
        'TTKP' => '',
        'TTPX' => '',
        'TTTTP' => '',

        'HTSN' => '',
        'HTD' => '',
        'HTKP' => '',
        'HTPX' => '',
        'HTTTP' => '',

        // STEP 3
        'OChungVoi' => '',
        'QuanHeNguoiNuoiDuong' => '',
        'ConThu' => '',
        'TSAnhChiEm' => '',
        'HoanThanhLopLa' => '',
        'TruongMamNon' => '',
        'KhaNangHocSinh' => [],
        'SucKhoeCanLuuY' => [],
        'SucKhoeKhac' => '',

        // STEP 4
        'HoTenCha' => '',
        'NamSinhCha' => '',
        'NgheNghiepCha' => '',
        'ChucVuCha' => '',
        'DienThoaiCha' => '',
        'CCCDCha' => '',

        'HoTenMe' => '',
        'NamSinhMe' => '',
        'NgheNghiepMe' => '',
        'ChucVuMe' => '',
        'DienThoaiMe' => '',
        'CCCDMe' => '',

        'HoTenNguoiGiamHo' => '',
        'QuanHeGiamHo' => '',
        'DienThoaiGiamHo' => '',
        'CCCDGiamHo' => '',

        // STEP 5
        'LoaiLopDangKy' => '',
        'CK_GocHocTap' => false,
        'CK_SachVo' => false,
        'CK_HopPH' => false,
        'CK_ThamGiaHD' => false,
        'CK_GanGui' => false,

        'NgayLamDon' => '',
        'NguoiLamDon' => '',
    ];

    protected $rules = [
        'form.HoVaTenHocSinh' => 'required|min:5',
        'form.MaDinhDanh' => 'required|digits:12',
        'form.LoaiLopDangKy' => 'required',
        'form.NguoiLamDon' => 'required',
    ];

    public function mount()
    {
        $this->provinces = AdmissionLocation::select('province_name')->distinct()->get()->toArray();
        $this->ethnicities = AdmissionCatalog::where('type', 'ethnicity')->get()->toArray();
        $this->religions = AdmissionCatalog::where('type', 'religion')->get()->toArray();

        $this->form['NgayLamDon'] = date('Y-m-d');
    }

    public function updated($field)
    {
        if ($field === 'form.TTTTP') {
            $this->tt_wards = AdmissionLocation::where('province_name', $this->form['TTTTP'])->get()->toArray();
        }

        if ($field === 'form.HTTTP') {
            $this->ht_wards = AdmissionLocation::where('province_name', $this->form['HTTTP'])->get()->toArray();
        }
    }

    public function updatedCopyNoiSinhToQueQuan($value)
    {
        if ($value) {
            $this->form['QueQuan'] = $this->form['NoiSinh'];
        }
    }
    // ================= SAME ADDRESS =================

    public function updatedSameAddress($value)
    {
        if ($value) {
            $this->form['HTSN'] = $this->form['TTSN'];
            $this->form['HTD'] = $this->form['TTD'];
            $this->form['HTKP'] = $this->form['TTKP'];
            $this->form['HTTTP'] = $this->form['TTTTP'];
            $this->form['HTPX'] = $this->form['TTPX'];

            $this->ht_wards = $this->tt_wards;
        }
    }

    public function updatedForm($value, $key)
    {
        if ($this->sameAddress) {

            $map = [
                'TTSN' => 'HTSN',
                'TTD' => 'HTD',
                'TTKP' => 'HTKP',
                'TTTTP' => 'HTTTP',
                'TTPX' => 'HTPX',
            ];

            if (isset($map[$key])) {
                $this->form[$map[$key]] = $value;
            }
        }
    }

    // ================= STEP =================

    public function nextStep()
    {
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    // ================= SAVE =================

    public function save(AdmissionService $service)
    {
        $this->validate();

        try {

            // ⚠️ CLONE DATA (QUAN TRỌNG)
            $data = $this->form;

            // ===== STEP 3 =====

            // Khả năng
            $data['KhaNangHocSinh'] = !empty($data['KhaNangHocSinh'])
                ? implode(', ', $data['KhaNangHocSinh'])
                : null;

            // Sức khỏe
            $health = $data['SucKhoeCanLuuY'] ?? [];

            if (!empty($data['SucKhoeKhac'])) {
                $health[] = $data['SucKhoeKhac'];
            }

            $data['SucKhoeCanLuuY'] = !empty($health)
                ? implode(', ', $health)
                : null;

            // Người nuôi dưỡng
            if (($data['OChungVoi'] ?? null) === 'other') {
                $data['OChungVoi'] = $data['QuanHeNguoiNuoiDuong'] ?? null;
            }

            // Trim
            $data = array_map(fn($v) => is_string($v) ? trim($v) : $v, $data);

            // SAVE
            $application = $service->createRegistration($data);

            if ($application && $application->id) {
                return redirect()->route('admission.download-word', [
                    'id' => $application->id
                ]);
            }

        } catch (\Exception $e) {

            \Log::error("Lỗi lưu đơn: " . $e->getMessage());

            session()->flash('error', 'Có lỗi xảy ra khi lưu.');
        }
    }

    public function render()
    {
        return view('Admission::livewire.admission.registration-form');
    }
}
