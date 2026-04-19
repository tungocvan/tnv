@extends('Admin::layouts.master')

@section('title', 'Quản lý hồ sơ')

@section('content')
    <div class="p-6 space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">
                Quản lý hồ sơ tuyển sinh
            </h1>
            <p class="text-sm text-gray-500">
                Danh sách và quản lý thông tin hồ sơ học sinh
            </p>
        </div>

        {{-- LIVEWIRE COMPONENT --}}
        @livewire('ntd.application.application-index')

    </div>
@endsection