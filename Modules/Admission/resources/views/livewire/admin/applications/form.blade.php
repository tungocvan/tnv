<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-sm">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $isEdit ? 'Chỉnh sửa hồ sơ' : 'Thêm mới hồ sơ' }}</h2>
                <p class="text-sm text-gray-500">Quản lý thông tin tuyển sinh năm học 2026 - 2027</p>
            </div>
            <a href="{{ route('admin.admission.index') }}" class="flex items-center text-gray-600 hover:text-blue-600 transition">
                <i class="fa fa-arrow-left mr-2"></i> Quay lại danh sách
            </a>
        </div>

        <form wire:submit.prevent="save" class="space-y-6">

            <div class="bg-blue-600 p-1 rounded-lg shadow-md">
                <div class="bg-white p-4 rounded-md grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-blue-900 uppercase">Trạng thái hồ sơ</label>
                        <select wire:model="form.Status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 font-semibold">
                            <option value="pending">🟡 Chờ duyệt (Pending)</option>
                            <option value="approved">🟢 Đã duyệt (Approved)</option>
                            <option value="rejected">🔴 Từ chối (Rejected)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-blue-900 uppercase">Loại lớp đăng ký</label>
                        <select wire:model="form.LoaiLopDangKy" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 font-semibold">
                            <option value="">-- Chọn loại lớp --</option>
                            <option value="Tăng cường Tiếng Anh">Tăng cường Tiếng Anh</option>
                            <option value="Lớp tiếng Anh tích hợp">Lớp tiếng Anh tích hợp</option>
                        </select>
                        @error('form.LoaiLopDangKy') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2 flex items-center">
                        <i class="fa fa-user-graduate mr-2 text-blue-500"></i> I. Thông tin học sinh
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium">Họ và tên học sinh <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="form.HoVaTenHocSinh" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm uppercase">
                            @error('form.HoVaTenHocSinh') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium">Giới tính</label>
                                <select wire:model="form.GioiTinh" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium">Ngày sinh <span class="text-red-500">*</span></label>
                                <input type="date" wire:model="form.NgaySinh" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium">Mã định danh <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="form.MaDinhDanh" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-mono">
                            </div>
                            <div>
                                <label class="text-sm font-medium">SĐT EnetViet <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="form.SDTEnetViet" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium">Dân tộc</label>
                                <input type="text" wire:model="form.DanToc" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="text-sm font-medium">Tôn giáo</label>
                                <input type="text" wire:model="form.TonGiao" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2 flex items-center">
                        <i class="fa fa-map-marker-alt mr-2 text-red-500"></i> II. Địa chỉ liên lạc
                    </h3>
                    <div class="space-y-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Thường trú</p>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" wire:model="form.TTSN" placeholder="Số nhà" class="rounded-md border-gray-300">
                            <input type="text" wire:model="form.TTD" placeholder="Tên đường" class="rounded-md border-gray-300">
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <input type="text" wire:model="form.TTKP" placeholder="Khu phố" class="rounded-md border-gray-300">
                            <input type="text" wire:model="form.TTPX" placeholder="Phường/Xã" class="rounded-md border-gray-300">
                            <input type="text" wire:model="form.TTTTP" placeholder="Quận/Huyện" class="rounded-md border-gray-300">
                        </div>

                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-4">Nơi ở hiện tại</p>
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" wire:model="form.HTSN" placeholder="Số nhà" class="rounded-md border-gray-300">
                            <input type="text" wire:model="form.HTD" placeholder="Tên đường" class="rounded-md border-gray-300">
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <input type="text" wire:model="form.HTKP" placeholder="Khu phố" class="rounded-md border-gray-300">
                            <input type="text" wire:model="form.HTPX" placeholder="Phường/Xã" class="rounded-md border-gray-300">
                            <input type="text" wire:model="form.HTTTP" placeholder="Quận/Huyện" class="rounded-md border-gray-300">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2 flex items-center">
                        <i class="fa fa-users mr-2 text-green-500"></i> III. Gia đình
                    </h3>
                    <div class="space-y-6">
                        <div class="p-3 bg-gray-50 rounded-md">
                            <label class="block text-sm font-bold text-gray-600 mb-2 underline">Thông tin Cha:</label>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" wire:model="form.HoTenCha" placeholder="Họ tên cha" class="rounded-md border-gray-300">
                                <input type="number" wire:model="form.NamSinhCha" placeholder="Năm sinh" class="rounded-md border-gray-300">
                            </div>
                            <input type="text" wire:model="form.DienThoaiCha" placeholder="Số điện thoại cha" class="mt-2 w-full rounded-md border-gray-300">
                        </div>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <label class="block text-sm font-bold text-gray-600 mb-2 underline">Thông tin Mẹ:</label>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" wire:model="form.HoTenMe" placeholder="Họ tên mẹ" class="rounded-md border-gray-300">
                                <input type="number" wire:model="form.NamSinhMe" placeholder="Năm sinh" class="rounded-md border-gray-300">
                            </div>
                            <input type="text" wire:model="form.DienThoaiMe" placeholder="Số điện thoại mẹ" class="mt-2 w-full rounded-md border-gray-300">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2 flex items-center">
                        <i class="fa fa-check-square mr-2 text-orange-500"></i> IV. Cam kết của phụ huynh
                    </h3>
                    <div class="space-y-3 bg-orange-50 p-4 rounded-md">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" wire:model="form.CK_GocHocTap" class="rounded text-blue-600 focus:ring-blue-500 h-5 w-5">
                            <span class="text-sm text-gray-700">Góc học tập tại nhà</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" wire:model="form.CK_SachVo" class="rounded text-blue-600 focus:ring-blue-500 h-5 w-5">
                            <span class="text-sm text-gray-700">Chuẩn bị đủ sách vở, đồ dùng</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" wire:model="form.CK_HopPH" class="rounded text-blue-600 focus:ring-blue-500 h-5 w-5">
                            <span class="text-sm text-gray-700">Tham gia họp phụ huynh đầy đủ</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" wire:model="form.CK_ThamGiaHD" class="rounded text-blue-600 focus:ring-blue-500 h-5 w-5">
                            <span class="text-sm text-gray-700">Tích cực tham gia hoạt động trường</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" wire:model="form.CK_GanGui" class="rounded text-blue-600 focus:ring-blue-500 h-5 w-5">
                            <span class="text-sm text-gray-700">Gần gũi, chia sẻ cùng con</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 bg-white p-4 rounded-lg shadow-inner border border-gray-200">
                <button type="button" onclick="confirm('Bạn có chắc muốn hủy bỏ?') && window.location.href='{{ route('admin.admission.index') }}'"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition font-medium">
                    Hủy bỏ
                </button>
                <button type="submit" wire:loading.attr="disabled"
                        class="px-10 py-2.5 rounded-lg bg-blue-700 text-white hover:bg-blue-800 shadow-lg shadow-blue-200 transition font-bold flex items-center">
                    <span wire:loading.remove wire:target="save">
                        <i class="fa fa-save mr-2"></i> {{ $isEdit ? 'Cập nhật hồ sơ' : 'Lưu hồ sơ mới' }}
                    </span>
                    <span wire:loading wire:target="save">
                        <i class="fa fa-spinner fa-spin mr-2"></i> Đang xử lý...
                    </span>
                </button>
            </div>
            @if($errors->has('save_error'))
                <div class="text-red-500 text-center font-bold p-2 bg-red-50 rounded border border-red-200">
                    {{ $errors->first('save_error') }}
                </div>
            @endif
        </form>
    </div>
</div>
