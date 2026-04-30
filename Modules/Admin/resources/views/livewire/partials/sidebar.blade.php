<aside x-data="{ sidebarOpen: @entangle('sidebarOpen'), open: {} }"
    class="flex flex-col h-screen transition-all duration-300
        {{ $theme['background'] }}
        {{ $theme['text'] }}"
    x-bind:class="sidebarOpen ? 'w-64' : 'w-20'">

    {{-- HEADER --}}
    <div class="h-16 flex items-center justify-center border-b {{ $theme['border'] }}">
        <span x-show="sidebarOpen" class="font-semibold">Admin</span>
        <span x-show="!sidebarOpen">A</span>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">

        @foreach ($menus as $menu)
            @php
                $isActive = $menu['url'] && request()->is(ltrim($menu['url'], '/') . '*');
            @endphp

            {{-- SINGLE --}}
            @if (!$menu['has_children'])
                <a href="{{ !empty($menu['url']) && is_string($menu['url']) ? url($menu['url']) : '#' }}"
                    class="flex items-center px-3 py-2 rounded-lg transition
                        {{ $isActive ? $theme['active_bg'] . ' ' . $theme['active_text'] : $theme['hover'] }}">

                    @if ($menu['icon'])
                        <x-icon name="{{ $menu['icon'] }}"
                            class="w-5 h-5
                                {{ $isActive ? $theme['icon_active'] : $theme['icon_inactive'] }}" />
                    @endif

                    <span x-show="sidebarOpen" class="ml-3 text-sm">
                        {{ $menu['name'] }}
                    </span>

                </a>

                {{-- GROUP --}}
            @else
                <div x-data="{ open: false }">

                    <button @click="sidebarOpen ? open = !open : sidebarOpen = true"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-lg transition
                            {{ $isActive ? $theme['active_bg'] . ' ' . $theme['active_text'] : $theme['hover'] }}">

                        <div class="flex items-center">
                            <x-icon name="{{ $menu['icon'] }}"
                                class="w-5 h-5
                                    {{ $isActive ? $theme['icon_active'] : $theme['icon_inactive'] }}" />

                            <span x-show="sidebarOpen" class="ml-3 text-sm">
                                {{ $menu['name'] }}
                            </span>
                        </div>
                        {{-- 🔥 ARROW CHỈ Ở MENU CHA --}}
                        <svg x-show="sidebarOpen" :class="open ? 'rotate-90' : ''"
                            class="w-4 h-4 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 6L14 10L6 14V6Z" />
                        </svg>
                    </button>
                    {{-- CHILDREN --}}
                    <div x-show="open && sidebarOpen" x-collapse class="ml-6 mt-1 space-y-1">
                        @foreach ($menu['children'] as $child)
                            @php
                                $childActive = request()->is(ltrim($child['url'], '/') . '*');
                            @endphp

                            <a href="{{ url($child['url']) }}"
                                class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition
                {{ $childActive
                    ? $theme['child_active_bg'] . ' ' . $theme['child_active_text']
                    : $theme['child_text'] . ' ' . $theme['child_hover'] }}">

                                {{-- ICON SUBMENU --}}
                                <svg class="w-3.5 h-3.5 opacity-70" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 6L14 10L6 14V6Z" />
                                </svg>

                                <span>
                                    {{ $child['name'] }}
                                </span>

                            </a>
                        @endforeach
                    </div>

                </div>
            @endif
        @endforeach

    </nav>

</aside>
