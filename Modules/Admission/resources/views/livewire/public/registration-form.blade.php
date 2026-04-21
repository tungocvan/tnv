<div>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        
        <div class="bg-gray-50 border-b px-8 py-6">
            <div class="flex items-center justify-between relative">
                @foreach(['Học sinh', 'Địa chỉ', 'Bổ sung', 'Phụ huynh', 'Hoàn tất'] as $index => $stepName)
                    <div class="flex flex-col items-center z-10 flex-1">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-lg transition-all duration-500 {{ $currentStep >= ($index + 1) ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'bg-white border-2 border-gray-200 text-gray-400' }}">
                            @if($currentStep > ($index + 1))
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <span class="text-xs mt-3 font-bold uppercase tracking-tighter {{ $currentStep >= ($index + 1) ? 'text-blue-700' : 'text-gray-400' }}">{{ $stepName }}</span>
                    </div>
                @endforeach
                <div class="absolute top-6 left-0 w-full h-1 bg-gray-200 -z-0">
                    <div class="h-1 bg-blue-600 transition-all duration-700" style="width: {{ (($currentStep - 1) / 4) * 100 }}%"></div>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save" class="p-8 sm:p-12">
            
            {{-- BƯỚC 1: THÔNG TIN HỌC SINH --}}
            @if($currentStep == 1)
            <div class="animate-in fade-in slide-in-from-right-5 duration-500">
                <h3 class="text-2xl font-black text-gray-800 mb-8 flex items-center uppercase">
                    <span class="w-2 h-8 bg-blue-600 rounded-full mr-3"></span> Bước 1: Thông tin định danh học sinh
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Họ và tên học sinh (*)</label>
                        <input type="text" wire:model="form.HoVaTenHocSinh" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 focus:ring-0 uppercase font-bold text-lg shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Giới tính (*)</label>
                        <select wire:model="form.GioiTinh" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold shadow-sm">
                            <option value="">-- Chọn --</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Ngày sinh (*)</label>
                        <input type="date" wire:model="form.NgaySinh" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Dân tộc</label>
                        <select wire:model="form.DanToc" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                            @foreach($ethnicities as $et) <option value="{{ $et['value'] }}">{{ $et['value'] }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Mã định danh (*)</label>
                        <input type="text" wire:model="form.MaDinhDanh" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500" maxlength="12">
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Quốc tịch</label>
                        <input type="text" wire:model="form.QuocTich" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Tôn giáo</label>
                        <select wire:model="form.TonGiao" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                            @foreach($religions as $rl) <option value="{{ $rl['value'] }}">{{ $rl['value'] }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">SĐT (EnetViet)</label>
                        <input type="text" wire:model="form.SDTEnetViet" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Nơi sinh (Tỉnh/Thành phố)</label>
                        <select wire:model="form.NoiSinh" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold">
                            <option value="">-- Chọn Tỉnh/Thành phố --</option>
                            @foreach($provinces as $p) <option value="{{ $p['province_name'] }}">{{ $p['province_name'] }}</option> @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Quê quán (Tỉnh/Thành phố)</label>
                        <select wire:model="form.QueQuan" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold">
                            <option value="">-- Chọn Tỉnh/Thành phố --</option>
                            @foreach($provinces as $p) <option value="{{ $p['province_name'] }}">{{ $p['province_name'] }}</option> @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Nơi đăng ký khai sinh</label>
                        <input type="text" wire:model="form.NoiDangKyKhaiSinh" class="w-full bg-white border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                    </div>
                </div>
            </div>
            @endif

            {{-- BƯỚC 2: ĐỊA CHỈ --}}
            @if($currentStep == 2)
            <div class="animate-in fade-in slide-in-from-right-5 duration-500 space-y-12">
                <div class="bg-blue-50/30 p-8 rounded-3xl border border-blue-100">
                    <h4 class="text-xl font-black text-blue-800 mb-6 flex items-center uppercase">Địa chỉ thường trú</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <input type="text" wire:model.blur="form.TTSN" placeholder="Số nhà" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <input type="text" wire:model.blur="form.TTD" placeholder="Đường" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <input type="text" wire:model.blur="form.TTKP" placeholder="Khu phố/Tổ" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <select wire:model.live="form.TTTTP" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold">
                            <option value="">-- Chọn Tỉnh/TP --</option>
                            @foreach($provinces as $p) <option value="{{ $p['province_name'] }}">{{ $p['province_name'] }}</option> @endforeach
                        </select>
                        <select wire:model.live="form.TTPX" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold" {{ empty($tt_wards) ? 'disabled' : '' }}>
                            <option value="">-- Chọn Phường/Xã --</option>
                            @foreach($tt_wards as $w) <option value="{{ $w['ward_name'] }}">{{ $w['ward_name'] }}</option> @endforeach
                        </select>
                    </div>
                </div>

                <div class="bg-green-50/30 p-8 rounded-3xl border border-green-100">
                    <h4 class="text-xl font-black text-green-800 mb-6 flex items-center uppercase">Nơi ở hiện tại</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <input type="text" wire:model.blur="form.HTSN" placeholder="Số nhà" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <input type="text" wire:model.blur="form.HTD" placeholder="Đường" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <input type="text" wire:model.blur="form.HTKP" placeholder="Khu phố/Tổ" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <select wire:model.live="form.HTTTP" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold">
                            <option value="">-- Chọn Tỉnh/TP --</option>
                            @foreach($provinces as $p) <option value="{{ $p['province_name'] }}">{{ $p['province_name'] }}</option> @endforeach
                        </select>
                        <select wire:model.live="form.HTPX" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold" {{ empty($ht_wards) ? 'disabled' : '' }}>
                            <option value="">-- Chọn Phường/Xã --</option>
                            @foreach($ht_wards as $w) <option value="{{ $w['ward_name'] }}">{{ $w['ward_name'] }}</option> @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @endif

            {{-- BƯỚC 3: THÔNG TIN BỔ SUNG --}}
            @if($currentStep == 3)
            <div class="animate-in fade-in slide-in-from-right-5 duration-500 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-black text-gray-700 mb-2">HỌC SINH ĐANG Ở CHUNG VỚI (*)</label>
                    <select wire:model="form.OChungVoi" class="w-full border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <option value="">-- Chọn --</option>
                        <option value="Cha mẹ">Cha mẹ</option><option value="Cha">Cha</option><option value="Mẹ">Mẹ</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-black text-gray-700 mb-2">LÀ CON THỨ MẤY?</label>
                    <input type="number" wire:model="form.ConThu" class="w-full border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-black text-gray-700 mb-2">TẠI TRƯỜNG MẦM NON</label>
                    <input type="text" wire:model="form.TruongMamNon" class="w-full border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-black text-gray-700 mb-2 uppercase">Lưu ý sức khỏe</label>
                    <textarea wire:model="form.SucKhoeCanLuuY" class="w-full border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500" rows="3"></textarea>
                </div>
            </div>
            @endif

            {{-- BƯỚC 4: THÔNG TIN PHỤ HUYNH (CHA/MẸ) --}}
            @if($currentStep == 4)
            <div class="animate-in fade-in slide-in-from-right-5 duration-500 space-y-10">
                <div class="border-l-8 border-blue-600 bg-blue-50/30 p-8 rounded-r-3xl">
                    <h4 class="text-xl font-black text-blue-700 mb-6 uppercase italic underline">Thông tin Cha</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <input type="text" wire:model="form.HoTenCha" placeholder="Họ tên cha (*)" class="md:col-span-2 border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold">
                        <input type="text" wire:model="form.NamSinhCha" placeholder="Năm sinh" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <input type="text" wire:model="form.DienThoaiCha" placeholder="SĐT (*)" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold">
                        <input type="text" wire:model="form.NgheNghiepCha" placeholder="Nghề nghiệp" class="md:col-span-2 border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <input type="text" wire:model="form.CCCDCha" placeholder="Số CCCD" class="md:col-span-2 border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                    </div>
                </div>

                <div class="border-l-8 border-pink-600 bg-pink-50/30 p-8 rounded-r-3xl">
                    <h4 class="text-xl font-black text-pink-700 mb-6 uppercase italic underline">Thông tin Mẹ</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <input type="text" wire:model="form.HoTenMe" placeholder="Họ tên mẹ (*)" class="md:col-span-2 border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold">
                        <input type="text" wire:model="form.NamSinhMe" placeholder="Năm sinh" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <input type="text" wire:model="form.DienThoaiMe" placeholder="SĐT (*)" class="border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500 font-bold">
                        <input type="text" wire:model="form.NgheNghiepMe" placeholder="Nghề nghiệp" class="md:col-span-2 border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                        <input type="text" wire:model="form.CCCDMe" placeholder="Số CCCD" class="md:col-span-2 border-2 border-gray-300 rounded-2xl p-4 focus:border-blue-500">
                    </div>
                </div>
            </div>
            @endif

            {{-- BƯỚC 5: ĐĂNG KÝ & CAM KẾT --}}
            @if($currentStep == 5)
            <div class="animate-in fade-in slide-in-from-right-5 duration-500 space-y-10">
                <div class="bg-gray-50 p-8 rounded-3xl border-2 border-gray-300">
                    <label class="block text-sm font-black text-gray-700 mb-4 uppercase">Lớp đăng ký vào học (*)</label>
                    <select wire:model="form.LoaiLopDangKy" class="w-full border-2 border-blue-600 rounded-2xl p-5 text-lg font-black text-blue-700 shadow-md">
                        <option value="">-- Click để chọn loại lớp --</option>
                        <option value="Tăng cường Tiếng Anh">Tăng cường Tiếng Anh</option>
                        <option value="Lớp tiếng Anh tích hợp">Lớp tiếng Anh tích hợp</option>
                        <option value="Tăng cường Tiếng Anh + (Toán và Khoa học)">Tăng cường Tiếng Anh + (Toán và Khoa học)</option>
                    </select>
                </div>

                <div class="bg-yellow-50/50 p-8 rounded-3xl border-2 border-yellow-300">
                    <h4 class="font-black text-yellow-800 mb-6 uppercase italic">Cam kết của Phụ huynh</h4>
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach(['CK_GocHocTap' => 'Có góc học tập cho con', 'CK_SachVo' => 'Đầy đủ sách vở dụng cụ', 'CK_HopPH' => 'Họp phụ huynh đầy đủ', 'CK_GanGui' => 'Gần gũi quan tâm con'] as $key => $label)
                        <label class="flex items-center space-x-3 p-4 bg-white rounded-2xl border-2 border-gray-200 cursor-pointer hover:border-yellow-500 transition shadow-sm">
                            <input type="checkbox" wire:model="form.{{ $key }}" class="w-6 h-6 text-yellow-600 rounded">
                            <span class="font-bold text-gray-700">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-black text-gray-700 mb-2 uppercase italic text-gray-400">Người làm đơn (Ký và ghi rõ họ tên)</label>
                        <input type="text" wire:model="form.NguoiLamDon" placeholder="HỌ TÊN PHỤ HUYNH" class="w-full border-4 border-blue-600 rounded-2xl p-6 text-2xl font-black text-blue-800 uppercase text-center shadow-2xl">
                    </div>
                </div>
            </div>
            @endif

            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-12 pt-10 border-t-2 border-gray-100">
                @if($currentStep > 1)
                    <button type="button" wire:click="prevStep" class="w-full sm:w-auto px-10 py-5 bg-gray-200 text-gray-800 font-black rounded-2xl hover:bg-gray-300 transition-all uppercase tracking-widest shadow-md">
                        QUAY LẠI
                    </button>
                @else
                    <div></div>
                @endif

                @if($currentStep < 5)
                    <button type="button" wire:click="nextStep" class="w-full sm:w-auto px-12 py-5 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-200 transition-all transform hover:-translate-y-1 uppercase tracking-widest">
                        TIẾP THEO
                    </button>
                @else
                    <button type="submit" wire:loading.attr="disabled" class="w-full sm:w-auto px-16 py-6 bg-gradient-to-r from-green-600 to-emerald-700 text-white font-black rounded-3xl hover:shadow-2xl transition-all transform hover:scale-105 uppercase tracking-widest shadow-xl flex items-center justify-center">
                        <span wire:loading.remove>HOÀN TẤT & XUẤT ĐƠN PDF</span>
                        <span wire:loading>ĐANG XỬ LÝ...</span>
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fade-in { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
    .animate-in { animation: fade-in 0.4s ease-out forwards; }
    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
    }
</style>
</div>