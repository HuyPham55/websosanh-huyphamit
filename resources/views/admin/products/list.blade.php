@extends('admin.layout')
@section('title', __('label.products'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ trans('label.products') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item active">
                    {{ __('label.products') }}
                </li>
            </ol>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            <div class="row mb-3">
                <div class="col justify-content-between align-items-center d-flex">
                    @can('add_products')
                        @includeIf('components.buttons.add', ['route' => route('products.add')])
                    @endcan
                    <div>
                        <a class="btn btn-outline-danger mb-2" href="{{route('products.clear_index')}}">
                            <i class="fas fa-fw fa-trash"></i>
                            Clear index
                        </a>
                        <a class="btn btn-outline-primary mb-2" href="{{route('products.add_all_to_index')}}">
                            <i class="fas fa-fw fa-plus"></i>
                            Bulk index
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>{{trans('label.total')}}: {{$total_count}}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="datatables">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">{{ __('label.image') }}</th>
                            <th scope="col">{{ __('label.title') }}</th>
                            <th scope="col">{{ __('label.scrapes') }}</th>
                            <th scope="col">{{ __('label.price') }}</th>
                            <th scope="col">{{ __('backend.sorting') }}</th>
                            <th scope="col">{{ __('label.status.status') }}</th>
                            <th scope="col">{{ __('label.created_at') }}</th>
                            <th scope="col">{{ __('label.action.action') }}</th>
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
@include('components.bootstrapSwitch')
@include('components.Datatables')

@push('js')
    <script type="text/javascript">
        jQuery(() => {
            let imageContainer = (data) => `<img src="${data}" style="max-width: 125px;"/>`;
            let sortingContainer = (data) => `<input class="update-sorting form-control" style="max-width: 125px;" type="number" value="${data}" max="e9"/>`;
            let datatablesCallback = () => {
                jQuery(".bt-switch input[type='checkbox']").bootstrapSwitch();
            }

            const formatMoney = function (value) {
                return new Intl.NumberFormat('de-DE', { style: 'currency', currency:'VND' }).format(value)
            }

            jQuery("#datatables").DataTable({
                serverSide: true,
                processing: true,
                responsive: true,
                ajax: '{{route('products.datatables')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image', orderable: false, render: imageContainer},
                    {data: 'title', name: 'title'},
                    {data: 'scrape_id', name: 'scrape_id'},
                    {data: 'price', name: 'price', render: formatMoney},
                    {data: 'sorting', name: 'sorting', render: sortingContainer},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false}
                ],
                drawCallback: datatablesCallback
            })


            jQuery(document).on('switchChange.bootstrapSwitch', '.change-status', function (event) {
                let field = jQuery(this).data('field');
                let tr = jQuery(this).closest("tr");
                let trId = tr.attr('id')
                let itemId = trId.split('row-id-')[1];
                let isChecked = event.target.checked;

                if (itemId) {
                    postData("{{route('products.change_status')}}", {
                        'field': field,
                        'item_id': itemId,
                        'status': isChecked ? 1 : 0,
                        '_token': '{{ csrf_token() }}'
                    });
                }
            });

            //change sorting
            jQuery(document).on('input', '.update-sorting', function (e) {
                e.stopPropagation();
                let tr = jQuery(this).closest("tr");
                let trId = tr.attr('id')
                let itemId = trId.split('row-id-')[1];
                let sorting = jQuery(this).val();

                if (itemId) {
                    postData("{{ route('products.change_sorting') }}", {
                        'item_id': itemId,
                        'sorting': sorting,
                        '_token': '{{ csrf_token() }}'
                    });
                }
            });
        })
    </script>
@endpush
