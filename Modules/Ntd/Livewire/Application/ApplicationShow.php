<?php

namespace Modules\Ntd\Livewire\Application;

use Livewire\Component;
use Modules\Ntd\Models\Application;

class ApplicationShow extends Component
{
    // ======================
    // STATE
    // ======================
    public $applicationId;
    public $application;

    // ======================
    // LIFECYCLE
    // ======================
    public function mount($id)
    {
        $this->applicationId = $id;

        // 🔥 Load 1 lần (performance)
        $this->application = Application::with('student')->findOrFail($id);
    }

    // ======================
    // ACTIONS
    // ======================
    public function previewPdf()
    {
        return redirect()->route('admin.ntd.applications.preview', $this->applicationId);
    }

    public function exportPdf()
    {
        return redirect()->route('admin.ntd.applications.export', $this->applicationId);
    }

    // ======================
    // RENDER
    // ======================
    public function render()
    {
        return view('Ntd::livewire.application.application-show');
    }
}