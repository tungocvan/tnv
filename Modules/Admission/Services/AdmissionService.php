<?php

namespace Modules\Admission\Services;

use Modules\Admission\Models\AdmissionApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;
use Carbon\Carbon;

class AdmissionService
{
    /**
     * Tạo mới đơn đăng ký từ Phụ huynh
     */
    public function createRegistration(array $formData)
    {
        // Tạo mã hồ sơ
        $mhs = 'MHS' . date('Y') . str_pad(AdmissionApplication::count() + 1, 4, '0', STR_PAD_LEFT);

        $dataToSave = [];
        foreach ($formData as $key => $value) {
            // Chuyển HoVaTenHocSinh -> ho_va_ten_hoc_sinh để khớp DB
            $dataToSave[Str::snake($key)] = $value;
        }

        $dataToSave['mhs'] = $mhs;
        $dataToSave['status'] = 'pending';

        return AdmissionApplication::create($dataToSave);
    }

    /**
     * Lấy danh sách đơn đăng ký cho Admin (CRUD)
     */
    public function getPaginatedList(array $filters = [], $perPage = 15)
    {
        $query = AdmissionApplication::query();

        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('ho_ten', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('ma_dinh_danh', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('mhs', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Cập nhật đơn
     */
    public function updateRegistration($id, array $data)
    {
        $application = AdmissionApplication::findOrFail($id);
        $application->update($data);
        return $application;
    }

    /**
     * Xóa đơn
     */
    public function deleteRegistration($id)
    {
        $application = AdmissionApplication::findOrFail($id);
        return $application->delete();
    }

    /**
     * Logic tạo mã MHS tự động: MHS + Năm + 4 số thứ tự
     */
    private function generateMhsCode()
    {
        $year = date('Y');
        $count = AdmissionApplication::whereYear('created_at', $year)->count() + 1;
        return 'MHS' . $year . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    /**
     * MAP DỮ LIỆU SANG PDF (FULL MAPPING THEO FILE WORD)
     * Hàm này chuẩn bị chính xác các Key mà template PDF/Blade sẽ sử dụng
     */
    public function getDataForPdf($id)
    {
        $app = AdmissionApplication::findOrFail($id);
        
        return [
            // Thông tin học sinh
            'MHS'               => $app->mhs,
            'HoVaTenHocSinh'    => mb_convert_case($app->ho_ten, MB_CASE_UPPER, "UTF-8"),
            'GioiTinh'          => $app->gioi_tinh,
            'NgaySinh'          => $app->ngay_sinh ? $app->ngay_sinh->format('d/m/Y') : '',
            'DanToc'            => $app->dan_toc,
            'MaDinhDanh'        => $app->ma_dinh_danh,
            'QuocTich'          => $app->quoc_tich,
            'TonGiao'           => $app->ton_giao,
            'SDTEnetViet'       => $app->sdt_enetviet,
            'NoiSinh'           => $app->noi_sinh,
            'NoiDangKyKhaiSinh' => $app->noi_dang_ky_khai_sinh,
            'QueQuan'           => $app->que_quan,

            // Địa chỉ thường trú
            'TTSN'              => $app->tt_so_nha,
            'TTD'               => $app->tt_duong,
            'TTKP'              => $app->tt_khu_pho,
            'TTPX'              => $app->tt_phuong_xa,
            'TTTTP'             => $app->tt_tinh_tp,
            'DiaChiThuongTru'   => trim("{$app->tt_so_nha} {$app->tt_duong}, {$app->tt_khu_pho}, {$app->tt_phuong_xa}, {$app->tt_tinh_tp}", " ,"),

            // Nơi ở hiện tại
            'HTSN'              => $app->ht_so_nha,
            'HTD'               => $app->ht_duong,
            'HTKP'              => $app->ht_khu_pho,
            'HTPX'              => $app->ht_phuong_xa,
            'HTTTP'             => $app->ht_tinh_tp,
            'NoiOHienTai'       => trim("{$app->ht_so_nha} {$app->ht_duong}, {$app->ht_khu_pho}, {$app->ht_phuong_xa}, {$app->ht_tinh_tp}", " ,"),

            // Thông tin bổ sung
            'OChungVoi'         => $app->o_chung_voi,
            'QuanHeNguoiNuoiDuong' => $app->quan_he_nguoi_nuoi_duong,
            'ConThu'            => $app->con_thu,
            'TSAnhChiEm'        => $app->tong_so_anh_em,
            'HoanThanhLopLa'    => $app->hoan_thanh_lop_la ? 'Có' : 'Không',
            'TruongMamNon'      => $app->truong_mam_non,
            'KhaNangHocSinh'    => $app->kha_nang_hoc_sinh,
            'SucKhoeCanLuuY'    => $app->suc_khoe_can_luu_y,

            // Thông tin Cha
            'HoTenCha'          => $app->cha_ho_ten,
            'NamSinhCha'        => $app->cha_nam_sinh,
            'TdvhCha'           => $app->cha_trinh_do_van_hoa,
            'TdcmCha'           => $app->cha_trinh_do_chuyen_mon,
            'NgheNghiepCha'     => $app->cha_nghe_nghiep,
            'ChucVuCha'         => $app->cha_chuc_vu,
            'DienThoaiCha'      => $app->cha_phone,
            'CCCDCha'           => $app->cha_cccd,

            // Thông tin Mẹ
            'HoTenMe'           => $app->me_ho_ten,
            'NamSinhMe'         => $app->me_nam_sinh,
            'TdvhMe'            => $app->me_trinh_do_van_hoa,
            'TdcmMe'            => $app->me_trinh_do_chuyen_mon,
            'NgheNghiepMe'      => $app->me_nghe_nghiep,
            'ChucVuMe'          => $app->me_chuc_vu,
            'DienThoaiMe'       => $app->me_phone,
            'CCCDMe'            => $app->me_cccd,

            // Thông tin Người giám hộ
            'HoTenNguoiGiamHo'  => $app->giam_ho_ho_ten,
            'QuanHeGiamHo'      => $app->giam_ho_quan_he,
            'DienThoaiGiamHo'   => $app->giam_ho_phone,
            'CCCDGiamHo'        => $app->giam_ho_cccd,

            // Anh chị ruột (JSON/Text)
            'AnhChiRuotTrongTruong' => $app->anh_chi_ruot_trong_truong,
            'ThanhPhanGiaDinh'      => $app->thanh_phan_gia_dinh,

            // Đăng ký & Cam kết
            'LoaiLopDangKy'     => $app->loai_lop_dang_ky,
            'CK_GocHocTap'      => $app->ck_goc_hoc_tap ? 'x' : '',
            'CK_SachVo'         => $app->ck_sach_vo ? 'x' : '',
            'CK_HopPH'          => $app->ck_hop_phu_huynh ? 'x' : '',
            'CK_ThamGiaHD'      => $app->ck_tham_gia_hd ? 'x' : '',
            'CK_GanGui'         => $app->ck_gan_gui ? 'x' : '',
            
            // Ngày tháng làm đơn
            'NgayLamDon'        => $app->created_at->format('d'),
            'ThangLamDon'       => $app->created_at->format('m'),
            'NamLamDon'         => $app->created_at->format('Y'),
            'NguoiLamDon'       => $app->nguoi_lam_don ?? $app->me_ho_ten ?? $app->cha_ho_ten,
        ];
    }
}