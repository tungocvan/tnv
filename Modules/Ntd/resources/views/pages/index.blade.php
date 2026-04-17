@extends('Ntd::layouts.frontend')
@php
        use Modules\Website\Models\Setting;
@endphp
@section('title', Setting::getValue('site_name'))
@section('content')
   <h2>NTD</h2>
@endsection