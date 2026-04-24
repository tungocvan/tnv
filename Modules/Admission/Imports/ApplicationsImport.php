<?php

namespace Modules\Admission\Imports;

use Modules\Admission\Models\AdmissionApplication;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ApplicationsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Map + insert/update
     */
    public function model(array $row)
    {
        // Chuẩn hóa dữ liệu
        $data = [
            'mhs' => $row['mhs'] ?? null,
            'status' => $row['status'] ?? 'pending',

            'ho_va_ten_hoc_sinh' => $row['ho_va_ten_hoc_sinh'] ?? null,
            'gioi_tinh' => $row['gioi_tinh'] ?? null,
            'ngay_sinh' => $row['ngay_sinh'] ?? null,
            'dan_toc' => $row['dan_toc'] ?? null,
            'ma_dinh_danh' => $row['ma_dinh_danh'] ?? null,
            'quoc_tich' => $row['quoc_tich'] ?? null,
            'ton_giao' => $row['ton_giao'] ?? null,
            'sdt_enetviet' => $row['sdt_enetviet'] ?? null,

            'noi_sinh' => $row['noi_sinh'] ?? null,
            'noi_dang_ky_khai_sinh' => $row['noi_dang_ky_khai_sinh'] ?? null,
            'que_quan' => $row['que_quan'] ?? null,

            // Địa chỉ
            'ttsn' => $row['ttsn'] ?? null,
            'ttd' => $row['ttd'] ?? null,
            'ttkp' => $row['ttkp'] ?? null,
            'ttpx' => $row['ttpx'] ?? null,
            'ttttp' => $row['ttttp'] ?? null,
            'dia_chi_thuong_tru' => $row['dia_chi_thuong_tru'] ?? null,

            'htsn' => $row['htsn'] ?? null,
            'htd' => $row['htd'] ?? null,
            'htkp' => $row['htkp'] ?? null,
            'htpx' => $row['htpx'] ?? null,
            'htttp' => $row['htttp'] ?? null,
            'noi_o_hien_tai' => $row['noi_o_hien_tai'] ?? null,

            // JSON fields
            'kha_nang_hoc_sinh' => $this->parseJson($row['kha_nang_hoc_sinh'] ?? null),
            'suc_khoe_can_luu_y' => $this->parseJson($row['suc_khoe_can_luu_y'] ?? null),

            // Phụ huynh
            'ho_ten_cha' => $row['ho_ten_cha'] ?? null,
            'dien_thoai_cha' => $row['dien_thoai_cha'] ?? null,

            'ho_ten_me' => $row['ho_ten_me'] ?? null,
            'dien_thoai_me' => $row['dien_thoai_me'] ?? null,

            'ho_ten_nguoi_giam_ho' => $row['ho_ten_nguoi_giam_ho'] ?? null,
            'dien_thoai_giam_ho' => $row['dien_thoai_giam_ho'] ?? null,

            // Đăng ký
            'loai_lop_dang_ky' => $row['loai_lop_dang_ky'] ?? null,
            'ngay_lam_don' => $row['ngay_lam_don'] ?? now(),
            'nguoi_lam_don' => $row['nguoi_lam_don'] ?? null,
        ];

        // UPSERT theo MHS
        return AdmissionApplication::updateOrCreate(
            ['mhs' => $data['mhs']],
            $data
        );
    }

    /**
     * Validate từng dòng
     */
    public function rules(): array
    {
        return [
            '*.mhs' => ['required'],
            '*.ho_va_ten_hoc_sinh' => ['required', 'string'],
            '*.gioi_tinh' => ['nullable', Rule::in(['nam', 'nu'])],
            '*.sdt_enetviet' => ['nullable', 'string'],
            '*.status' => ['nullable', Rule::in(['pending', 'approved', 'rejected'])],
            '*.loai_lop_dang_ky' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom message
     */
    public function customValidationMessages()
    {
        return [
            '*.mhs.required' => 'Thiếu MHS',
            '*.ho_va_ten_hoc_sinh.required' => 'Thiếu tên học sinh',
        ];
    }

    /**
     * Parse JSON field
     */
    protected function parseJson($value)
    {
        if (!$value) return null;

        if (is_array($value)) return $value;

        // hỗ trợ dạng: a,b,c
        if (is_string($value)) {
            return array_map('trim', explode(',', $value));
        }

        return null;
    }
}
