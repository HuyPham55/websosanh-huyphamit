@extends('admin.layout')

@section('title',__('label.change_password'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('label.change_password') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('label.change_password') }}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            <div class="card">
                <form action="" method="POST" class="form-horizontal pt-3">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="old_password"
                                   class="col-sm-2 control-label col-form-label">{{ trans('label.member.old_password') }}</label>
                            <div class="col-sm-10">
                                <input type="password" id="old_password" name="old_password" value=""
                                       class="form-control" minlength="8">
                                @error('old_password')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                   class="col-sm-2 control-label col-form-label">{{ __('label.member.new_password') }}</label>
                            <div class="col-sm-10">
                                <input type="password" id="password" name="password" value="{{ old('password') }}"
                                       class="form-control" minlength="8">
                                @error('password')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                   class="col-sm-2 control-label col-form-label">{{ __('label.member.password_confirmation') }}</label>
                            <div class="col-sm-10">
                                <input type="password" id="password" name="password_confirmation"
                                       value="{{ old('password_confirmation') }}"
                                       class="form-control" minlength="8">
                                @error('password_confirmation')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="action-form">
                            <div class="form-group mb-0 text-center">
                                @includeIf('components.buttons.submit')
                                @includeIf('components.buttons.cancel')
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection()
