@extends('admin.layout')
@section('title', trans('label.comparisons')." ".__('label.products'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ trans('label.comparisons')." - ".__('label.products') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item active">
                    {{ trans('label.comparisons') }}
                </li>
                <li class="breadcrumb-item active">
                    {{ trans('label.products') }}
                </li>
            </ol>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            <div class="col justify-content-between align-items-center d-flex">
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>{{$model->title}}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="datatables">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">{{ __('label.image') }}</th>
                            <th scope="col">{{ __('label.title') }}</th>
                            <th scope="col">{{ __('label.sellers') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection()
@include('components.toastr')
@include('components.Datatables')

@push('js')
    <script type="text/javascript">
        jQuery(() => {
            let imageContainer = (data) => `<img src="${data}" style="max-width: 125px;"/>`;
            let sortingContainer = (data) => `<input class="update-sorting form-control" style="max-width: 125px;" type="number" value="${data}" max="e9"/>`;
            let datatablesCallback = () => {

            }
            jQuery("#datatables").DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: '{{route('comparison_active_products.datatables', ['id' => $model->id])}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image', orderable: false, render: imageContainer},
                    {data: 'title', name: 'title'},
                    {data: 'seller', name: 'seller'},
                ],
                drawCallback: datatablesCallback
            })
        })
    </script>
@endpush
