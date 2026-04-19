@extends('Admin::layouts.master')

@section('title', 'Chi tiết hồ sơ')

@section('content')
    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Chi tiết hồ sơ
            </h1>
            <p class="text-sm text-gray-500">
                Xem thông tin hồ sơ học sinh
            </p>
        </div>

        {{-- LIVEWIRE --}}
        @livewire('ntd.application.application-show', ['id' => $id])

    </div>
@endsection