<div>
    <div class="max-w-7xl mx-auto p-6 space-y-8 bg-gray-50 min-h-screen">

        {{-- HEADER --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 flex justify-between items-center shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $isEdit ? 'Chỉnh sửa hồ sơ' : 'Tạo hồ sơ tuyển sinh' }}
                </h1>
                <p class="text-sm text-gray-500 mt-1">Quản lý thông tin tuyển sinh</p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.admission.index') }}" class="btn-secondary">
                    ← Quay lại
                </a>

                <button wire:click="save" class="btn-primary">
                    💾 Lưu
                </button>
            </div>
        </div>

        <form wire:submit.prevent="save" class="space-y-8">

            {{-- STEP 1 --}}
            <div class="card">
                <h2 class="section-title text-blue-700">🎓 Thông tin học sinh</h2>

                <div class="grid md:grid-cols-3 gap-6">

                    <div>
                        <label class="label">Họ và tên</label>
                        <input type="text" wire:model="form.HoVaTenHocSinh" class="input">
                    </div>

                    <div>
                        <label class="label">Mã định danh</label>
                        <input type="text" wire:model="form.MaDinhDanh" class="input">
                    </div>

                    <div>
                        <label class="label">Ngày sinh</label>
                        <input type="date" wire:model="form.NgaySinh" class="input">
                    </div>

                    <div>
                        <label class="label">Giới tính</label>
                        <select wire:model="form.GioiTinh" class="input">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Dân tộc</label>
                        <x-select-search id="dan_toc" wire:model="form.DanToc" placeholder="Chọn dân tộc...">
                            <option value="">-- Chọn --</option>
                            @foreach ($ethnics as $et)
                                <option value="{{ $et['value'] }}">{{ $et['value'] }}</option>
                            @endforeach
                        </x-select-search>
                    </div>


                    {{-- TÔN GIÁO --}}
                    <div>
                        <label class="text-sm font-medium">Tôn giáo</label>
                        <x-select-search id="ton_giao" wire:model="form.TonGiao" placeholder="Chọn tôn giáo...">
                            <option value="">-- Chọn --</option>
                            @foreach ($religions as $rl)
                                <option value="{{ $rl['value'] }}">{{ $rl['value'] }}</option>
                            @endforeach
                        </x-select-search>
                    </div>

                    <div>
                        <label class="label">SĐT (EnetViet)</label>
                        <input type="text" wire:model="form.SDTEnetViet" class="input">
                    </div>

                    {{-- NƠI SINH --}}
                    <div>
                        <label class="text-sm font-medium">
                            Nơi sinh (Tỉnh/TP)
                        </label>
                        <x-select-search id="noi_sinh" wire:model="form.NoiSinh" placeholder="Chọn nơi sinh...">
                            <option value="">-- Chọn --</option>
                            @foreach ($provinces as $p)
                                <option value="{{ $p['province_name'] }}">{{ $p['province_name'] }}</option>
                            @endforeach
                        </x-select-search>
                    </div>

                    <div>
                        <label class="label">Nơi đăng ký khai sinh</label>
                        <input type="text" wire:model="form.NoiDangKyKhaiSinh" class="input">
                    </div>

                    {{-- QUÊ QUÁN --}}
                    <div>
                        <label class="text-sm font-medium">
                            Quê quán
                        </label>
                        <x-select-search id="que_quan" wire:model="form.QueQuan" placeholder="Chọn quê quán...">
                            <option value="">-- Chọn --</option>
                            @foreach ($provinces as $p)
                                <option value="{{ $p['province_name'] }}">{{ $p['province_name'] }}</option>
                            @endforeach
                        </x-select-search>
                    </div>

                </div>
            </div>

            {{-- STEP 2 --}}
            <div class="card">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="section-title text-green-700">🏠 Địa chỉ</h2>

                    <label class="flex items-center gap-2 text-sm font-semibold text-blue-600 cursor-pointer">
                        <input type="checkbox" wire:model="isSameAsPermanent" class="rounded">
                        Giống thường trú
                    </label>
                </div>

                <div class="grid md:grid-cols-2 gap-8">

                    {{-- THƯỜNG TRÚ --}}
                    {{-- ĐỊA CHỈ THƯỜNG TRÚ --}}
    <div class="bg-blue-50/40 border border-blue-100 rounded-2xl p-6 space-y-6">
        <h4 class="text-lg font-bold text-blue-700 uppercase">
            Địa chỉ thường trú
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <input type="text" wire:model.blur="form.TTSN"
                placeholder="Số nhà"
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition">

            <input type="text" wire:model.blur="form.TTD"
                placeholder="Đường"
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition">

            <input type="text" wire:model.blur="form.TTKP"
                placeholder="Khu phố / Tổ"
                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition">

            {{-- Tỉnh --}}
            <x-select-search id="ttttp"
                wire:model.live="form.TTTTP"
                placeholder="Tỉnh / Thành phố">
                <option value="">-- Chọn --</option>
                @foreach ($provinces as $p)
                    <option value="{{ $p['province_name'] }}">
                        {{ $p['province_name'] }}
                    </option>
                @endforeach
            </x-select-search>

            {{-- Phường --}}
            <x-select-search id="ttpx"
                options-wire="tt_wards"
                wire:model.live="form.TTPX"
                placeholder="Phường / Xã">
                <option value="">-- Chọn --</option>

                @if (!empty($tt_wards))
                    @foreach ($tt_wards as $w)
                        <option value="{{ $w['ward_name'] }}">
                            {{ $w['ward_name'] }}
                        </option>
                    @endforeach
                @endif
            </x-select-search>

        </div>
    </div>

                    {{-- HIỆN TẠI --}}
                    <div class="sub-card bg-blue-50 {{ $isSameAsPermanent ? 'opacity-50 pointer-events-none' : '' }}">
                        <p class="sub-title text-blue-700">Hiện tại</p>

                        <x-select-search id="http" wire:model.live="form.HTTTP" :options="$provinces"
                            placeholder="Tỉnh/TP" />

                        <x-select-search id="htpx" wire:model="form.HTPX" options-wire="htWards"
                            placeholder="Phường/Xã" />

                        <input type="text" wire:model="form.HTD" placeholder="Số nhà, đường" class="input">
                    </div>

                </div>
            </div>

            {{-- STEP 3 --}}
            <div class="card">
                <h2 class="section-title text-indigo-700">⭐ Thông tin bổ sung</h2>

                <div class="grid md:grid-cols-2 gap-8">

                    <div>
                        <p class="font-semibold mb-3">Khả năng</p>

                        @foreach (['Tự tin', 'Biết bơi', 'Biết đọc viết'] as $item)
                            <label class="flex gap-2">
                                <input type="checkbox" wire:model="form.KhaNangHocSinh" value="{{ $item }}">
                                {{ $item }}
                            </label>
                        @endforeach

                        <input type="text" wire:model="form.KhaNangKhac" class="input mt-2"
                            placeholder="Khác...">
                    </div>

                    <div>
                        <p class="font-semibold mb-3">Sức khỏe</p>

                        @foreach (['Dị ứng', 'Hen'] as $item)
                            <label class="flex gap-2">
                                <input type="checkbox" wire:model="form.SucKhoeCanLuuY" value="{{ $item }}">
                                {{ $item }}
                            </label>
                        @endforeach

                        <input type="text" wire:model="form.SucKhoeKhac" class="input mt-2"
                            placeholder="Khác...">
                    </div>

                </div>
            </div>

            {{-- STEP 4 --}}
            <div class="grid md:grid-cols-2 gap-8">

                <div class="card">
                    <h3 class="section-title text-blue-700">👨 Cha</h3>

                    <input type="text" wire:model="form.HoTenCha" class="input" placeholder="Họ tên">
                    <input type="text" wire:model="form.NamSinhCha" class="input" placeholder="Năm sinh">
                    <input type="text" wire:model="form.DienThoaiCha" class="input" placeholder="Điện thoại">
                    <input type="text" wire:model="form.NgheNghiepCha" class="input" placeholder="Nghề nghiệp">
                </div>

                <div class="card">
                    <h3 class="section-title text-pink-700">👩 Mẹ</h3>

                    <input type="text" wire:model="form.HoTenMe" class="input" placeholder="Họ tên">
                    <input type="text" wire:model="form.NamSinhMe" class="input" placeholder="Năm sinh">
                    <input type="text" wire:model="form.DienThoaiMe" class="input" placeholder="Điện thoại">
                    <input type="text" wire:model="form.NgheNghiepMe" class="input" placeholder="Nghề nghiệp">
                </div>

            </div>

            {{-- STEP 5 --}}
            <div class="card">
                <h2 class="section-title text-orange-600">📌 Đăng ký & Cam kết</h2>

                <select wire:model="form.LoaiLopDangKy" class="input">
                    <option value="">-- Chọn lớp --</option>
                    <option value="Tăng cường">Tăng cường</option>
                    <option value="Tích hợp">Tích hợp</option>
                </select>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    @foreach ([
        'CK_GocHocTap' => 'Góc học tập',
        'CK_SachVo' => 'Sách vở',
        'CK_HopPH' => 'Họp PH',
    ] as $key => $label)
                        <label class="flex gap-2">
                            <input type="checkbox" wire:model="form.{{ $key }}">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.admission.index') }}" class="btn-secondary">Hủy</a>
                <button type="submit" class="btn-primary">
                    {{ $isEdit ? 'Cập nhật' : 'Lưu hồ sơ' }}
                </button>
            </div>

        </form>
    </div>

    {{-- STYLE --}}
    <style>
        .card {
            @apply bg-white border border-gray-200 rounded-2xl p-6 shadow-sm;
        }

        .sub-card {
            @apply p-4 border rounded-xl bg-gray-50 space-y-3;
        }

        .section-title {
            @apply text-lg font-bold mb-6;
        }

        .sub-title {
            @apply font-semibold text-gray-600;
        }

        .label {
            @apply text-sm font-medium text-gray-700 mb-1 block;
        }

        .input {
            @apply w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
        }

        .btn-primary {
            @apply px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold shadow hover:bg-blue-700;
        }

        .btn-secondary {
            @apply px-5 py-2 border border-gray-300 rounded-xl text-gray-600 hover:bg-gray-100;
        }
    </style>
</div>
