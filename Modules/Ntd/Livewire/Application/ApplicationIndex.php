<?php

namespace Modules\Ntd\Livewire\Application;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Ntd\Models\Application;

class ApplicationIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // ======================
    // STATE
    // ======================
    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    // ======================
    // LIFECYCLE
    // ======================
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    // ======================
    // QUERY
    // ======================
    public function getApplicationsProperty()
    {
        $query = Application::query()
            ->select([
                'applications.id',
                'applications.code',
                'applications.status',
                'applications.created_at',
            ])

            // 🔥 JOIN
            ->leftJoin('students', 'students.application_id', '=', 'applications.id');

        // 🔍 SEARCH
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('applications.code', 'like', '%' . $this->search . '%')
                    ->orWhere('students.full_name', 'like', '%' . $this->search . '%')
                    ->orWhere('students.identity_number', 'like', '%' . $this->search . '%');
            });
        }

        // 🔽 FILTER
        if ($this->statusFilter !== '') {
            $query->where('applications.status', $this->statusFilter);
        }

        // 🔃 SORT mapping
        $sortFieldMap = [
            'code' => 'applications.code',
            'status' => 'applications.status',
            'created_at' => 'applications.created_at',
            'identity_number' => 'students.identity_number',
        ];

        $sortColumn = $sortFieldMap[$this->sortField] ?? 'applications.created_at';

        $query->orderBy($sortColumn, $this->sortDirection);

        // 🔥 EAGER LOAD
        $query->with([
            'student:id,application_id,full_name,date_of_birth,gender,phone,identity_number'
        ]);

        return $query->paginate($this->perPage);
    }

    // ======================
    // ACTIONS
    // ======================
    public function goToCreate()
    {
        return redirect()->route('admin.ntd.applications.create');
    }

    public function goToEdit($id)
    {
        return redirect()->route('admin.ntd.applications.edit', $id);
    }

    public function goToShow($id)
    {
        return redirect()->route('admin.ntd.applications.show', $id);
    }

    public function export($id)
    {
        return redirect()->route('admin.ntd.applications.export', $id);
    }
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    // ======================
    // RENDER
    // ======================
    public function render()
    {
        return view('Ntd::livewire.application.application-index', [
            'applications' => $this->applications,
        ]);
    }
}
