@extends('admin.layout')

@section('title', trans('label.action.edit'))


@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ trans('label.action.edit') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.list') }}">{{ __('backend.user_list') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('label.action.add') }}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            <div class="card">
                @include('admin.user.form')
            </div>
        </div>
    </div>
@endsection
@section('plugins.Select2', true)

