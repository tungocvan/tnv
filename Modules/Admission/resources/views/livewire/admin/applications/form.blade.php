<div>
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">

    <div class="max-w-6xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $isEdit ? 'Chỉnh sửa hồ sơ' : 'Tạo hồ sơ tuyển sinh' }}
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Admission Management System • 2026 - 2027
                </p>
            </div>

            <a href="{{ route('admin.admission.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200
                      hover:bg-gray-50 transition text-gray-600 font-medium">
                ← Quay lại
            </a>
        </div>

        {{-- FORM --}}
        <form wire:submit.prevent="save"
              class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            {{-- TOP CONTROL BAR --}}
            <div class="bg-gray-50 border-b p-5 flex flex-wrap gap-4 justify-between items-center">

                <div class="flex gap-4 w-full md:w-auto">

                    <div class="w-full md:w-64">
                        <label class="text-xs font-bold text-gray-500 uppercase">Trạng thái</label>
                        <select wire:model="form.Status"
                                class="mt-1 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="pending">🟡 Chờ duyệt</option>
                            <option value="approved">🟢 Đã duyệt</option>
                            <option value="rejected">🔴 Từ chối</option>
                        </select>
                    </div>

                    <div class="w-full md:w-80">
                        <label class="text-xs font-bold text-gray-500 uppercase">Loại lớp</label>
                        <select wire:model="form.LoaiLopDangKy"
                                class="mt-1 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">-- Chọn loại lớp --</option>
                            <option value="Tăng cường Tiếng Anh">Tăng cường Tiếng Anh</option>
                            <option value="Lớp tiếng Anh tích hợp">Lớp tiếng Anh tích hợp</option>
                        </select>
                    </div>

                </div>

                <div class="text-xs text-gray-400">
                    * Các trường có dấu (*) là bắt buộc
                </div>

            </div>

            {{-- BODY --}}
            <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- STUDENT --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-4">

                    <h2 class="font-bold text-gray-700 flex items-center gap-2">
                        👨‍🎓 Thông tin học sinh
                    </h2>

                    <div class="space-y-3">

                        <div>
                            <label class="text-sm font-medium">Họ và tên *</label>
                            <input wire:model="form.HoVaTenHocSinh"
                                   class="input-admin">
                        </div>

                        <div class="grid grid-cols-2 gap-3">

                            <div>
                                <label class="text-sm font-medium">Giới tính</label>
                                <select wire:model="form.GioiTinh" class="input-admin">
                                    <option>Nam</option>
                                    <option>Nữ</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-medium">Ngày sinh *</label>
                                <input type="date" wire:model="form.NgaySinh" class="input-admin">
                            </div>

                        </div>

                        <div class="grid grid-cols-2 gap-3">

                            <div>
                                <label class="text-sm font-medium">Mã định danh *</label>
                                <input wire:model="form.MaDinhDanh" class="input-admin font-mono">
                            </div>

                            <div>
                                <label class="text-sm font-medium">SĐT EnetViet *</label>
                                <input wire:model="form.SDTEnetViet" class="input-admin">
                            </div>

                        </div>

                        <div class="grid grid-cols-2 gap-3">

                            <div>
                                <label class="text-sm font-medium">Dân tộc</label>
                                <input wire:model="form.DanToc" class="input-admin">
                            </div>

                            <div>
                                <label class="text-sm font-medium">Tôn giáo</label>
                                <input wire:model="form.TonGiao" class="input-admin">
                            </div>

                        </div>

                    </div>
                </div>

                {{-- ADDRESS --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-4">

                    <h2 class="font-bold text-gray-700 flex items-center gap-2">
                        📍 Địa chỉ
                    </h2>

                    <div class="space-y-3">

                        <p class="text-xs font-bold text-gray-400 uppercase">Thường trú</p>

                        <div class="grid grid-cols-2 gap-3">
                            <input wire:model="form.TTSN" placeholder="Số nhà" class="input-admin">
                            <input wire:model="form.TTD" placeholder="Đường" class="input-admin">
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <input wire:model="form.TTKP" placeholder="Khu phố" class="input-admin">
                            <input wire:model="form.TTPX" placeholder="Phường/Xã" class="input-admin">
                            <input wire:model="form.TTTTP" placeholder="Quận/Huyện" class="input-admin">
                        </div>

                        <p class="text-xs font-bold text-gray-400 uppercase mt-4">Hiện tại</p>

                        <div class="grid grid-cols-2 gap-3">
                            <input wire:model="form.HTSN" placeholder="Số nhà" class="input-admin">
                            <input wire:model="form.HTD" placeholder="Đường" class="input-admin">
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <input wire:model="form.HTKP" placeholder="Khu phố" class="input-admin">
                            <input wire:model="form.HTPX" placeholder="Phường/Xã" class="input-admin">
                            <input wire:model="form.HTTTP" placeholder="Quận/Huyện" class="input-admin">
                        </div>

                    </div>
                </div>

                {{-- PARENTS --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-4">

                    <h2 class="font-bold text-gray-700 flex items-center gap-2">
                        👨‍👩‍👧 Gia đình
                    </h2>

                    <div class="space-y-4">

                        <div class="p-4 bg-gray-50 rounded-xl space-y-2">
                            <p class="font-semibold text-sm">Cha</p>
                            <input wire:model="form.HoTenCha" placeholder="Họ tên" class="input-admin">
                            <input wire:model="form.NamSinhCha" placeholder="Năm sinh" class="input-admin">
                            <input wire:model="form.DienThoaiCha" placeholder="SĐT" class="input-admin">
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl space-y-2">
                            <p class="font-semibold text-sm">Mẹ</p>
                            <input wire:model="form.HoTenMe" placeholder="Họ tên" class="input-admin">
                            <input wire:model="form.NamSinhMe" placeholder="Năm sinh" class="input-admin">
                            <input wire:model="form.DienThoaiMe" placeholder="SĐT" class="input-admin">
                        </div>

                    </div>
                </div>

                {{-- COMMITMENT --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5 space-y-4">

                    <h2 class="font-bold text-gray-700 flex items-center gap-2">
                        ✅ Cam kết
                    </h2>

                    <div class="space-y-3">

                        @foreach([
                            'CK_GocHocTap' => 'Góc học tập',
                            'CK_SachVo' => 'Sách vở đầy đủ',
                            'CK_HopPH' => 'Họp phụ huynh',
                            'CK_ThamGiaHD' => 'Tham gia hoạt động',
                            'CK_GanGui' => 'Quan tâm con'
                        ] as $key => $label)

                            <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 cursor-pointer border">
                                <input type="checkbox" wire:model="form.{{ $key }}"
                                       class="w-5 h-5 text-blue-600">
                                <span class="text-sm font-medium">{{ $label }}</span>
                            </label>

                        @endforeach

                    </div>

                </div>

            </div>

            {{-- ACTION BAR --}}
            <div class="flex justify-end gap-3 p-5 border-t bg-gray-50">

                <a href="{{ route('admin.admission.index') }}"
                   class="px-5 py-2 rounded-xl border bg-white hover:bg-gray-100 font-medium">
                    Hủy
                </a>

                <button type="submit"
                        class="px-8 py-2 rounded-xl bg-blue-600 text-white font-bold
                               hover:bg-blue-700 shadow-lg shadow-blue-200
                               flex items-center gap-2">

                    <span wire:loading.remove wire:target="save">
                        💾 {{ $isEdit ? 'Cập nhật' : 'Lưu hồ sơ' }}
                    </span>

                    <span wire:loading wire:target="save">
                        ⏳ Đang xử lý...
                    </span>

                </button>

            </div>

        </form>
    </div>
</div>


</div>    