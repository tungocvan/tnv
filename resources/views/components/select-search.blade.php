@props(['placeholder' => 'Chọn một mục...', 'id', 'options' => []])

<div wire:ignore class="w-full">
    <select
        {{ $attributes->merge(['class' => 'w-full']) }}
        id="{{ $id }}"
        x-data="{
            instance: null,
            init() {
                this.instance = new TomSelect('#{{ $id }}', {
                    plugins: ['dropdown_input'],
                    placeholder: '{{ $placeholder }}',
                    create: false,
                    allowEmptyOption: true,
                    onChange: (value) => {
                        @this.set('{{ $attributes->wire('model')->value() }}', value);
                    }
                });

                // Lắng nghe khi dữ liệu từ Livewire thay đổi (quan trọng cho phường/xã)
                $watch('$wire.{{ $attributes->get('options-wire', '') }}', (newOptions) => {
                    this.instance.clearOptions();
                    if (newOptions && Object.keys(newOptions).length > 0) {
                        const formattedOptions = Object.values(newOptions).map(item => ({
                            // Tùy chỉnh key theo dữ liệu của bạn (ward_name hoặc name)
                            value: item.ward_name || item.name || item,
                            text: item.ward_name || item.name || item
                        }));
                        this.instance.addOptions(formattedOptions);
                    }
                    this.instance.refreshOptions(false);
                });
            }
        }"
    >
        {{ $slot }}
    </select>
</div>

@once
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <style>
        /* Tùy chỉnh để khớp với Tailwind 4 */
        .ts-control { border-radius: 0.375rem !important; padding: 0.5rem !important; }
        .ts-wrapper.focus .ts-control { box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5) !important; border-color: #3b82f6 !important; }
    </style>
@endonce
