@php
    use App\Enums\CommonStatus;
@endphp
@extends('admin.layout')
@section('title', trans('label.slide'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('label.slide') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('label.slide') }}</li>
            </ol>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            @can('add_home_slides')
                @includeIf('components.buttons.add', ['route' => route('home_slides.add')])
            @endcan
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>{{trans('label.total')}}: {{$data->total()}}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                            <tr>
                                <th scope="col">{{ __('label.image') }}</th>
                                <th scope="col">{{ __('backend.sorting') }}</th>
                                <th scope="col">{{ __('label.status.status') }}</th>
                                <th scope="col">{{ __('label.created_at') }}</th>
                                <th scope="col">{{ __('label.action.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($data as $item)
                                <tr id="row-id-{{ $item->id }}">
                                    <td>
                                        <img src="{{ either($item->image, '/images/no-image.png') }}"
                                             style="max-width: 125px;" alt="">
                                    </td>
                                    <td>
                                        @if(auth()->user()->can('edit_home_slides'))
                                            <input type="number" value="{{ $item->sorting }}"
                                                   data-item="{{ $item->id }}" title=""
                                                   class="update-sorting" style="max-width: 75px;" min="0" max="e9"
                                                   placeholder="0">
                                        @else
                                            {{ $item->sorting }}
                                        @endif
                                    </td>
                                    <td class="bt-switch">
                                        <input type="checkbox" class="change-status" data-field="status"
                                               data-item-id="{{ $item->id }}" title=""
                                               data-size="normal" data-on-color="success"
                                               data-on-text="{{ __('label.on') }}" data-off-text="{{ __('label.off') }}"
                                               {{ $item->status == 1 ? 'checked' : '' }}
                                               @cannot('edit_blog_categories')
                                                   disabled
                                            @endcannot
                                        />
                                    </td>
                                    <td>{{ $item->date_format }}</td>
                                    <td>
                                        @can('edit_home_slides')
                                            @includeIf('components.buttons.edit', ['route' => route('home_slides.edit', $item->id)])
                                        @endcan

                                        @can('edit_home_slides')
                                            @includeIf('components.buttons.delete', ['route' => route('home_slides.delete'), 'id' => $item->id])
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" style="text-align: center"><i>No record</i></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-center">
                            {{ $data->appends(request()->all())->onEachSide(1)->links() }}
                        </div>
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
                    postData("{{ route('home_slides.change_status') }}", {
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
                    postData("{{ route('home_slides.change_sorting') }}", {
                        'item_id': itemId,
                        'sorting': sorting,
                        '_token': '{{ csrf_token() }}'
                    });
                }
            });
        })
    </script>
@endpush
