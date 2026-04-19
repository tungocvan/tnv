<div class="bg-white shadow rounded-xl p-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-lg font-semibold">
                Mã hồ sơ: {{ $application->code }}
            </h2>

            {{-- STATUS --}}
            <span class="text-xs px-2 py-1 rounded bg-gray-200">
                {{ $application->status }}
            </span>
        </div>

        {{-- ACTION --}}
        <div class="flex gap-2">
            <button wire:click="previewPdf"
                class="px-4 py-2 bg-yellow-500 text-white rounded">
                Preview PDF
            </button>

            <button wire:click="exportPdf"
                class="px-4 py-2 bg-green-600 text-white rounded">
                Export PDF
            </button>
        </div>
    </div>

    {{-- STUDENT --}}
    <div class="grid grid-cols-2 gap-4">

        <div>
            <label class="text-sm text-gray-500">Họ tên</label>
            <p class="font-medium">
                {{ $application->student?->full_name ?? '-' }}
            </p>
        </div>

        <div>
            <label class="text-sm text-gray-500">Giới tính</label>
            <p>
                {{ $application->student?->gender ?? '-' }}
            </p>
        </div>

        <div>
            <label class="text-sm text-gray-500">Ngày sinh</label>
            <p>
                {{ $application->student?->date_of_birth ?? '-' }}
            </p>
        </div>

        <div>
            <label class="text-sm text-gray-500">SĐT</label>
            <p>
                {{ $application->student?->phone ?? '-' }}
            </p>
        </div>

        <div>
            <label class="text-sm text-gray-500">Mã định danh</label>
            <p>
                {{ $application->student?->identity_number ?? '-' }}
            </p>
        </div>

    </div>

    {{-- ADDRESS --}}
    <div>
        <h3 class="font-semibold">Địa chỉ</h3>

        <p class="text-sm text-gray-600">
            {{ data_get($application->addresses, 'permanent.house_number', '-') }}
        </p>
    </div>

</div>