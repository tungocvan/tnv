<div class="max-w-7xl mx-auto py-10 px-4 space-y-6">

    @include('Admission::livewire.admission.partials.error-summary')

    @include('Admission::livewire.admission.partials.stepper')

    <form wire:submit.prevent="save" class="space-y-8">

        @if($currentStep == 1)
            @include('Admission::livewire.admission.partials.step-1-student')
        @endif

        @if($currentStep == 2)
            @include('Admission::livewire.admission.partials.step-2-address')
        @endif

        @if($currentStep == 3)
            @include('Admission::livewire.admission.partials.step-3-extra')
        @endif

        @if($currentStep == 4)
            @include('Admission::livewire.admission.partials.step-4-parent')
        @endif

        @if($currentStep == 5)
            @include('Admission::livewire.admission.partials.step-5-confirm')
        @endif

        @include('Admission::livewire.admission.partials.actions')

    </form>




</div>
