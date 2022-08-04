@extends('admin.layout')

@php
    $targetLabel = __('label.roles');
    $actionLabel = trans('label.action.edit');
    $title = $targetLabel." - ".$actionLabel;
@endphp

@section('title', $title)
@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ $actionLabel }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('role.list') }}">{{ $targetLabel }}</a></li>
                <li class="breadcrumb-item active">{{ $actionLabel }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            @include('admin.role.form')
        </div>
    </div>
@endsection()
