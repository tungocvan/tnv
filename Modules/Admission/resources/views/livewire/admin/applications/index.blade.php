<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Danh sách hồ sơ tuyển sinh</h2>
        <div class="text-sm text-gray-500">Tổng số: {{ $applications->total() }} hồ sơ</div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Tìm tên, mã định danh, SĐT..."
            class="border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">

        <select wire:model="filterClass" class="border-gray-300 rounded-lg shadow-sm">
            <option value="">-- Tất cả loại lớp --</option>
            <option value="Tăng cường Tiếng Anh">Tăng cường Tiếng Anh</option>
            <option value="Lớp tiếng Anh tích hợp">Lớp tiếng Anh tích hợp</option>
        </select>

        <select wire:model="filterStatus" class="border-gray-300 rounded-lg shadow-sm">
            <option value="">-- Tất cả trạng thái --</option>
            <option value="pending">Đang chờ duyệt</option>
            <option value="approved">Đã duyệt</option>
            <option value="rejected">Từ chối</option>
        </select>

        <button wire:click="$refresh" class="bg-gray-100 px-4 py-2 rounded-lg font-medium hover:bg-gray-200">Làm mới
            </option>
    </div>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">MHS</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Học sinh</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lớp đăng ký</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày nộp</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($applications as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-blue-600">{{ $item->mhs }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $item->ho_va_ten_hoc_sinh }}</div>
                            <div class="text-xs text-gray-500">Định danh: {{ $item->ma_dinh_danh }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->lo_ai_lop_dang_ky }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 text-xs rounded-full
                            {{ $item->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $item->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $item->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                            <a href="{{ route('admin.admission.edit', $item->id) }}"
                                class="text-blue-600 hover:text-blue-900">Chi tiết</a>
                            <a href="{{ route('admission.download-pdf', $item->id) }}"
                                class="text-red-500 hover:text-red-700" title="Xuất PDF">
                                <i class="fa fa-file-pdf"></i> Pdf
                            </a>

                            <a href="{{ route('admission.download-word', $item->id) }}"
                                class="text-green-600 hover:text-green-900">
                                <i class="fa fa-download"></i> Word
                            </a>

                            <button onclick="confirm('Xóa hồ sơ này?') || event.stopImmediatePropagation()"
                                wire:click="delete({{ $item->id }})"
                                class="text-red-600 hover:text-red-900">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t">
            {{ $applications->links() }}
        </div>
    </div>
</div>
