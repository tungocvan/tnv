<?php

namespace Modules\Admission\Livewire\Admin\Applications;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Admission\Models\AdmissionApplication;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterClass = '';

    // Cấu hình cập nhật URL khi tìm kiếm (để f5 không mất filter)
    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterClass' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        AdmissionApplication::findOrFail($id)->delete();
        session()->flash('message', 'Đã xóa hồ sơ thành công.');
    }

    public function render()
    {
        $query = AdmissionApplication::query();

        // Tìm kiếm theo tên, mã định danh hoặc số điện thoại
        if ($this->search) {
            $query->where(function($q) {
                $q->where('ho_va_ten_hoc_sinh', 'like', '%' . $this->search . '%')
                  ->orWhere('ma_dinh_danh', 'like', '%' . $this->search . '%')
                  ->orWhere('sdt_enetviet', 'like', '%' . $this->search . '%');
            });
        }

        // Lọc theo trạng thái
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        // Lọc theo loại lớp
        if ($this->filterClass) {
            $query->where('loai_lop_dang_ky', $this->filterClass);
        }

        $applications = $query->latest()->paginate(10);

        return view('Admission::livewire.admin.applications.index', [
            'applications' => $applications
        ]);
    }
}
