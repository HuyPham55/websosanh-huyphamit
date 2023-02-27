@extends('admin.layout')
@section('title', __('backend.banners'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('backend.banners') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item"><a href="#">{{ __('label.settings') }}</a></li>
                <li class="breadcrumb-item active">{{ __('backend.banners') }}</li>
            </ol>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            <form action="" method="POST" class="form-horizontal pt-3">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        @foreach($bannerKeys as $bannerKey => $banner)
                            <div class="form-group row">
                                <label for="logo"
                                       class="col-sm-2  control-label">{{ data_get($banner, 'label') }}</label>

                                <div class="col-sm-10">
                                    @includeIf('components.select_file', [
                                        'keyId' => $bannerKey,
                                        'inputName' => $bannerKey,
                                        'inputValue' => old($bannerKey) ?? option($bannerKey),
                                        'lfmType' => 'image',
                                        'note' => data_get($banner, 'note'),
                                    ])
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="card-body">
                        <div class="action-form">
                            <div class="form-group mb-0 text-center">
                                @includeIf('components.buttons.submit')
                                @includeIf('components.buttons.cancel')
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection()
