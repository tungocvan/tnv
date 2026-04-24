<?php

namespace Modules\Admission\Livewire\Admin\Applications;

use Livewire\Component;
use Modules\Admission\Models\AdmissionApplication;
use Modules\Admission\Models\AdmissionCatalog;
use Modules\Admission\Models\AdmissionLocation;
use Modules\Admission\Services\AdmissionService;
use Illuminate\Support\Facades\Log;

class Form extends Component
{
    public $applicationId;
    public $isEdit = false;
    public bool $isSameAsPermanent = false;

    // DATA SELECT
    public $ethnics = [];
    public $religions = [];
    public $provinces = [];
    public $ttWards = [];
    public $htWards = [];

    public $form = [
        'Status' => 'pending',

        // STEP 1
        'HoVaTenHocSinh' => '',
        'GioiTinh' => 'Nam',
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
        'KhaNangKhac' => '',
        'SucKhoeCanLuuY' => [],
        'SucKhoeKhac' => '',

        // STEP 4
        'HoTenCha' => '',
        'NamSinhCha' => '',
        'NgheNghiepCha' => '',
        'DienThoaiCha' => '',

        'HoTenMe' => '',
        'NamSinhMe' => '',
        'NgheNghiepMe' => '',
        'DienThoaiMe' => '',

        // STEP 5
        'LoaiLopDangKy' => '',

        // CAM KET
        'CK_GocHocTap' => false,
        'CK_SachVo' => false,
        'CK_HopPH' => false,
        'CK_ThamGiaHD' => false,
        'CK_GanGui' => false,
    ];

    protected function rules()
    {
        return [
            'form.HoVaTenHocSinh' => 'required',
            'form.MaDinhDanh' => 'required|digits:12',
            'form.NgaySinh' => 'required|date',
            'form.SDTEnetViet' => 'required',
            'form.LoaiLopDangKy' => 'required',
        ];
    }

    public function mount($id = null)
    {
        // ===== LOAD SELECT =====

        // FIX column name (không dùng name)
        $this->ethnics =  AdmissionCatalog::where('type', 'ethnicity')->get()->toArray();
        $this->religions = AdmissionCatalog::where('type', 'religion')->get()->toArray();
        $this->provinces = AdmissionLocation::select('province_name')->distinct()->get()->toArray();


        // ===== EDIT MODE =====
        if ($id) {
            $this->isEdit = true;
            $this->applicationId = $id;

            $app = AdmissionApplication::findOrFail($id);

            $this->form = array_merge($this->form, [
                'Status' => $app->status,
                'HoVaTenHocSinh' => $app->ho_va_ten_hoc_sinh,
                'GioiTinh' => $app->gioi_tinh,
                'NgaySinh' => $app->ngay_sinh,
                'DanToc' => $app->dan_toc,
                'MaDinhDanh' => $app->ma_dinh_danh,
                'TonGiao' => $app->ton_giao,
                'SDTEnetViet' => $app->sdt_enetviet,
                'NoiSinh' => $app->noi_sinh,
                'NoiDangKyKhaiSinh' => $app->noi_dang_ky_khai_sinh,
                'QueQuan' => $app->que_quan,

                'TTTTP' => $app->ttttp,
                'TTPX' => $app->ttpx,
                'HTTTP' => $app->htttp,
                'HTPX' => $app->htpx,

                'HoTenCha' => $app->ho_ten_cha,
                'DienThoaiCha' => $app->dien_thoai_cha,
                'HoTenMe' => $app->ho_ten_me,
                'DienThoaiMe' => $app->dien_thoai_me,
            ]);

            $this->loadWards('TT');
            $this->loadWards('HT');
        }
    }

    // ===== LOAD WARDS =====
    public function loadWards($type)
    {
        $province = $type === 'TT' ? $this->form['TTTTP'] : $this->form['HTTTP'];

        if (!$province) return;

        $wards = AdmissionLocation::where('province_name', $province)->get();

        $formatted = $wards->map(fn($w) => [
            'value' => $w->ward_name,
            'text' => $w->ward_name,
        ])->toArray();

        if ($type === 'TT') {
            $this->ttWards = $formatted;
        } else {
            $this->htWards = $formatted;
        }
    }

    // ===== AUTO COPY ADDRESS =====
    public function updatedForm($value, $key)
    {
        if ($key === 'TTTTP') $this->loadWards('TT');
        if ($key === 'HTTTP') $this->loadWards('HT');

        if ($this->isSameAsPermanent && str_starts_with($key, 'TT')) {
            $this->form[str_replace('TT', 'HT', $key)] = $value;
        }
    }

    public function updatedIsSameAsPermanent($value)
    {
        if ($value) {
            foreach (['SN','D','KP','TTP','PX'] as $f) {
                $this->form['HT'.$f] = $this->form['TT'.$f];
            }
            $this->loadWards('HT');
        }
    }

    // ===== SAVE =====
    public function save(AdmissionService $service)
    {
        $this->validate();

        try {
            $data = $this->form;

            // FIX ARRAY → STRING
            $data['KhaNangHocSinh'] = implode(', ', array_filter([
                ...$data['KhaNangHocSinh'],
                $data['KhaNangKhac']
            ]));

            $data['SucKhoeCanLuuY'] = implode(', ', array_filter([
                ...$data['SucKhoeCanLuuY'],
                $data['SucKhoeKhac']
            ]));

            if ($this->isEdit) {
                $service->updateRegistration($this->applicationId, $data);
            } else {
                $service->createRegistration($data);
            }

            return redirect()->route('admin.admission.index')
                ->with('success', 'Lưu thành công');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->addError('save_error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('Admission::livewire.admin.applications.form');
    }
}
