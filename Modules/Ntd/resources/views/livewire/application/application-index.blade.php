<div class="p-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">
                Danh sách hồ sơ
            </h1>
            <p class="text-sm text-gray-500">
                Quản lý hồ sơ tuyển sinh
            </p>
        </div>

        <button wire:click="goToCreate" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
            + Thêm mới
        </button>
    </div>

    {{-- TOOLBAR --}}
    <div class="flex gap-4 items-center">
        <select wire:model.live="perPage" class="text-sm border px-2 py-1">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        {{-- SEARCH --}}
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Tìm theo tên hoặc mã..."
            class="w-64 px-3 py-2 border rounded text-sm">

        {{-- FILTER --}}
        <select wire:model.live="statusFilter" class="px-3 py-2 border rounded text-sm">
            <option value="">Tất cả trạng thái</option>
            <option value="draft">Nháp</option>
            <option value="submitted">Đã nộp</option>
        </select>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border rounded overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600 text-sm">
                <tr>

                    {{-- STT --}}
                    <th class="px-4 py-3 text-left">#</th>

                    {{-- MÃ HỒ SƠ --}}
                    <th wire:click="sortBy('code')" class="px-4 py-3 text-left cursor-pointer select-none">
                        Mã hồ sơ
                        @if ($sortField === 'code')
                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>

                    {{-- CCCD --}}
                    <th wire:click="sortBy('identity_number')" class="px-4 py-3 cursor-pointer">
                        Mã định danh
                        @if ($sortField === 'identity_number')
                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>

                    {{-- HỌ TÊN --}}
                    <th class="px-4 py-3 text-left">
                        Họ tên
                    </th>

                    {{-- NGÀY SINH --}}
                    <th class="px-4 py-3 text-left">
                        Ngày sinh
                    </th>

                    {{-- GIỚI TÍNH --}}
                    <th class="px-4 py-3 text-left">
                        Giới tính
                    </th>

                    {{-- SĐT --}}
                    <th class="px-4 py-3 text-left">
                        SĐT
                    </th>

                    {{-- TRẠNG THÁI --}}
                    <th wire:click="sortBy('status')" class="px-4 py-3 text-left cursor-pointer select-none">
                        Trạng thái
                        @if ($sortField === 'status')
                            <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>

                    {{-- ACTION --}}
                    <th class="px-4 py-3 text-left">
                        Hành động
                    </th>

                </tr>
            </thead>

            <tbody>
                @forelse ($applications as $index => $app)
                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-4 py-3">
                            {{ $applications->firstItem() + $index }}
                        </td>

                        <td class="px-4 py-3 font-medium">
                            {{ $app->code }}
                        </td>
                        <td class="px-4 py-3 font-medium">
                            {{ $app->student?->identity_number ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $app->student->full_name ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $app->student->date_of_birth ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ optional($app->student)->gender }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $app->student->phone ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded bg-gray-200">
                                {{ $app->status }}
                            </span>
                        </td>

                        <td class="px-4 py-3 flex gap-2">

                            <button wire:click="goToShow({{ $app->id }})"
                                class="text-blue-600 hover:underline text-xs">
                                Xem
                            </button>

                            <button wire:click="goToEdit({{ $app->id }})"
                                class="text-green-600 hover:underline text-xs">
                                Sửa
                            </button>

                            <button wire:click="export({{ $app->id }})"
                                class="text-gray-600 hover:underline text-xs">
                                Export
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500">
                            Chưa có hồ sơ nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div>
        {{ $applications->links() }}
    </div>

</div>
