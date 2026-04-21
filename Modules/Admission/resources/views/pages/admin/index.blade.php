@extends('Admin::layouts.master')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Danh sách Đơn đăng ký Nhập học</h2>
        <a href="{{ route('admin.admission.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Thêm đơn mới</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-left text-sm uppercase">
                    <th class="px-5 py-3 border-b-2">MHS</th>
                    <th class="px-5 py-3 border-b-2">Học sinh</th>
                    <th class="px-5 py-3 border-b-2">Ngày nộp</th>
                    <th class="px-5 py-3 border-b-2">Trạng thái</th>
                    <th class="px-5 py-3 border-b-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                </tbody>
        </table>
    </div>
</div>
@endsection