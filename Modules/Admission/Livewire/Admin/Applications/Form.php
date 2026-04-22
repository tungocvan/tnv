<?php

namespace Modules\Admission\Livewire\Admin\Applications;

use Livewire\Component;
use Modules\Admission\Models\AdmissionApplication;
use Modules\Admission\Services\AdmissionService;
use Illuminate\Support\Facades\Log;

class Form extends Component
{

    public $applicationId;
    public $isEdit = false;

    // Mảng form chứa các key khớp 100% với AdmissionService chuẩn bị
    public $form = [
        'Status' => 'pending',
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
        'TTSN' => '',
        'TTD' => '',
        'TTKP' => '',
        'TTPX' => '',
        'TTTTP' => 'TP. Hồ Chí Minh',
        'HTSN' => '',
        'HTD' => '',
        'HTKP' => '',
        'HTPX' => '',
        'HTTTP' => 'TP. Hồ Chí Minh',
        'LoaiLopDangKy' => '',
        'HoTenCha' => '',
        'NamSinhCha' => '',
        'DienThoaiCha' => '',
        'HoTenMe' => '',
        'NamSinhMe' => '',
        'DienThoaiMe' => '',
        'CK_GocHocTap' => false,
        'CK_SachVo' => false,
        'CK_HopPH' => false,
        'CK_ThamGiaHD' => false,
        'CK_GanGui' => false,
    ];

    /**
     * Quy tắc kiểm tra dữ liệu (Validation)
     */
    protected function rules()
    {
        return [
            'form.HoVaTenHocSinh' => 'required|string|max:255',
            'form.MaDinhDanh' => 'required|string|max:25',
            'form.NgaySinh' => 'required|date',
            'form.SDTEnetViet' => 'required|numeric',
            'form.LoaiLopDangKy' => 'required',
            'form.Status' => 'required',
        ];
    }

    protected $messages = [
        'form.HoVaTenHocSinh.required' => 'Vui lòng nhập họ tên học sinh.',
        'form.MaDinhDanh.required' => 'Mã định danh là bắt buộc.',
        'form.NgaySinh.required' => 'Vui lòng chọn ngày sinh.',
        'form.SDTEnetViet.required' => 'Số điện thoại EnetViet không được để trống.',
        'form.LoaiLopDangKy.required' => 'Vui lòng chọn loại lớp đăng ký.',
    ];

    public function mount($id = null)
    {

        if ($id) {
            $this->isEdit = true;
            $this->applicationId = $id;
            $app = AdmissionApplication::findOrFail($id);

            // Đổ dữ liệu từ Database (snake_case) vào Form (CamelCase)
            $this->form = [
                'Status'             => $app->status,
                'HoVaTenHocSinh'     => $app->ho_va_ten_hoc_sinh,
                'GioiTinh'           => $app->gioi_tinh,
                'NgaySinh'           => $app->ngay_sinh,
                'DanToc'             => $app->dan_toc,
                'MaDinhDanh'         => $app->ma_dinh_danh,
                'QuocTich'           => $app->quoc_tich,
                'TonGiao'            => $app->ton_giao,
                'SDTEnetViet'        => $app->sdt_enetviet,
                'NoiSinh'            => $app->noi_sinh,
                'NoiDangKyKhaiSinh'  => $app->noi_dang_ky_khai_sinh,
                'QueQuan'            => $app->que_quan,
                'TTSN'               => $app->ttsn,
                'TTD'                => $app->ttd,
                'TTKP'               => $app->ttkp,
                'TTPX'               => $app->ttpx,
                'TTTTP'              => $app->ttttp,
                'HTSN'               => $app->htsn,
                'HTD'                => $app->htd,
                'HTKP'               => $app->htkp,
                'HTPX'               => $app->htpx,
                'HTTTP'              => $app->htttp,
                'LoaiLopDangKy'      => $app->loai_lop_dang_ky,
                'HoTenCha'           => $app->ho_ten_cha,
                'NamSinhCha'         => $app->nam_sinh_cha,
                'DienThoaiCha'       => $app->dien_thoai_cha,
                'HoTenMe'            => $app->ho_ten_me,
                'NamSinhMe'          => $app->nam_sinh_me,
                'DienThoaiMe'        => $app->dien_thoai_me,
                'CK_GocHocTap'       => (bool)$app->ck_goc_hoc_tap,
                'CK_SachVo'          => (bool)$app->ck_sach_vo,
                'CK_HopPH'           => (bool)$app->ck_hop_ph,
                'CK_ThamGiaHD'       => (bool)$app->ck_tham_gia_hd,
                'CK_GanGui'          => (bool)$app->ck_gan_gui,
            ];
        }
    }

    public function save(AdmissionService $service)
    {
        $this->validate();

        try {
            if ($this->isEdit) {
                // Sử dụng hàm updateRegistration của Service đã viết lại
                $service->updateRegistration($this->applicationId, $this->form);
                session()->flash('message', 'Cập nhật hồ sơ thành công!');
            } else {
                // Sử dụng hàm createRegistration của Service đã viết lại
                $service->createRegistration($this->form);
                session()->flash('message', 'Thêm mới hồ sơ thành công!');
            }

            return redirect()->route('admin.admission.index');

        } catch (\Exception $e) {
            Log::error('Admin Save Admission Error: ' . $e->getMessage());
            $this->addError('save_error', 'Đã xảy ra lỗi khi lưu: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('Admission::livewire.admin.applications.form');
    }
}
