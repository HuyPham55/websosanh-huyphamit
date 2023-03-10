@extends('admin.layout')
@section('title', __('label.products').' - '.trans('label.category'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ trans('label.category') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item"><a href="#">{{ __('label.products') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('label.category') }}</li>
            </ol>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            @can('add_product_categories')
                @includeIf('components.buttons.add', ['route' => route('product_categories.add')])
            @endcan
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>{{trans('label.total')}}: {{count($categories)}}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('label.title') }}</th>
                                <th scope="col">{{ __('backend.sorting') }}</th>
                                <th scope="col">{{ __('label.status.status') }}</th>
                                <th scope="col">{{ __('label.action.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @includeIf('admin.product_categories.rows', ['categories' => $categories])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
@include('components.toastr')
@include('components.bootstrapSwitch')

@push('js')
    <script type="text/javascript">
        jQuery(() => {
            jQuery(".bt-switch input[type='checkbox']").bootstrapSwitch();

            jQuery('.change-status').on('switchChange.bootstrapSwitch', function (event) {
                let field = jQuery(this).data('field');
                let itemId = jQuery(this).data('item-id');
                let isChecked = event.target.checked;

                if (itemId) {
                    postData("{{ route('product_categories.change_status') }}", {
                        'field': field,
                        'item_id': itemId,
                        'status': isChecked ? 1 : 0,
                        '_token': '{{ csrf_token() }}'
                    });
                }
            });

            jQuery('.update-sorting').on('input', function () {
                let itemId = jQuery(this).data('item');
                let sorting = jQuery(this).val();

                if (itemId) {
                    postData("{{ route('product_categories.change_sorting') }}", {
                        'item_id': itemId,
                        'sorting': sorting,
                        '_token': '{{ csrf_token() }}'
                    });
                }
            });
        })
    </script>
@endpush
