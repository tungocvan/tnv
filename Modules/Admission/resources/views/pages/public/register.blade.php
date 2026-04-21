@extends('Admin::layouts.master')

@section('content')
<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-extrabold text-blue-900">CỔNG ĐĂNG KÝ NHẬP HỌC TRỰC TUYẾN</h1>
                <p class="text-gray-600 mt-2">Vui lòng điền đầy đủ và chính xác thông tin để làm hồ sơ nhập học cho con.</p>
            </div>

            @livewire('admission.public.registration-form')
        </div>
    </div>
</div>
@endsection