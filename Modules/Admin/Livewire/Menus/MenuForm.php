<?php

namespace Modules\Admin\Livewire\Menus;

use Livewire\Component;
use Modules\Website\Models\Category;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class MenuForm extends Component
{
    public $menuId;
    public $isEdit = false;

    public $name, $url, $icon, $can;
    public $is_active = true;
    public $is_section = false;

    protected $rules;

    public function __construct()
    {
        $this->rules = config('menu.validation', [
            'name' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'can' => 'nullable|exists:permissions,name',
            'is_active' => 'boolean',
        ]);
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->isEdit = true;
            $this->menuId = $id;
            $menu = Category::findOrFail($id);

            $this->name = $menu->name;
            $this->url = $menu->url;
            $this->icon = $menu->icon;
            $this->can = $menu->can;
            $this->is_active = (bool)$menu->is_active;

            // Logic nhận diện section
            if (empty($menu->url) && $menu->children->count() > 0 && empty($menu->parent_id)) {
                 // Đây là logic tương đối, bạn có thể tick thủ công
            }
             // Nếu user đã chủ động set url null khi tạo
            $this->is_section = empty($menu->url);
        }
    }

    public function updatedIsSection($val) {
        if($val) $this->url = null;
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'url' => $this->is_section ? null : $this->url,
                'icon' => $this->icon,
                'can' => $this->can,
                'type' => 'menu',
                'is_active' => $this->is_active,
            ];

            // Mặc định tạo mới thì nằm cuối cùng (sort_order cao nhất)
            if (!$this->isEdit) {
                $data['sort_order'] = Category::menu()->max('sort_order') + 1;
            }

            $menu = Category::updateOrCreate(['id' => $this->menuId], $data);

            // Clear cache
            \Illuminate\Support\Facades\Cache::forget(config('menu.cache.key', 'admin.menus'));

            // Log action
            \Illuminate\Support\Facades\Log::info('Menu saved', [
                'menu_id' => $menu->id,
                'menu_name' => $menu->name,
                'action' => $this->isEdit ? 'updated' : 'created',
                'user_id' => auth()->id()
            ]);

            session()->flash('success', 'Đã lưu thông tin menu.');
            return redirect()->route('admin.menus.index');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Menu save failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'data' => $this->except(['menuId', 'isEdit'])
            ]);

            session()->flash('error', 'Lỗi khi lưu menu: ' . $e->getMessage());
            return back();
        }
    }

    public function render()
    {
        return view('Admin::livewire.menus.menu-form', [
            'permissions' => Permission::orderBy('name')->get()
        ]);
    }
}
