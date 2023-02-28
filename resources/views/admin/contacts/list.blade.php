@php
    use App\Enums\CommonStatus;
@endphp
@extends('admin.layout')
@section('title', trans('label.contact_requests'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('label.contact_requests') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('label.home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('label.contact_requests') }}</li>
            </ol>
        </div>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            @includeIf('components.notification')
            @include('admin.contacts.filter_bar')

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4>{{trans('label.total')}}: {{$contacts->total()}}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                            <tr>
                                <th scope="col">{{ __('label.created_at') }}</th>
                                <th scope="col">{{ __('label.subject') }}</th>
                                <th scope="col">{{ __('label.name') }}</th>
                                <th scope="col">{{ __('label.email') }}</th>
                                <th scope="col">{{ __('label.favourite') }}</th>
                                <th scope="col">{{ __('label.action.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($contacts as $item)
                                <tr id="row-id-{{ $item->id }}">
                                    <td>
                                        {{$item->date_format}}
                                    </td>
                                    <td>{{ $item->subject }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>

                                    <td class="bt-switch">
                                        <input type="checkbox" class="change-status" data-field="favourite"
                                               data-item-id="{{ $item->id }}" title=""
                                               data-size="normal" data-on-color="success"
                                               data-on-text="{{ __('label.on') }}" data-off-text="{{ __('label.off') }}"
                                               {{ $item->status == 1 ? 'checked' : '' }}
                                               @cannot('edit_faqs')
                                                   disabled
                                            @endcannot
                                        />
                                    </td>
                                    <td>
                                        @can('delete_contacts')
                                            <button type="button" class="btn show-detail-contact {{$item->is_read?'btn-info':'btn-outline-info'}}"
                                                    data-contact-id="{{ $item->id }}">
                                                <i class="fas fa-fw fa-eye"></i> {{ __('label.action.show') }}
                                            </button>
                                            @includeIf('components.buttons.delete', ['route' => route('contacts.delete'), 'id' => $item->id])
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
                            {{ $contacts->appends(request()->all())->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{trans('label.details')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa faw fa-times"></i>
                        {{trans('label.action.close')}}
                    </button>
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
                    postData("{{ route('contacts.change_favourite') }}", {
                        'field': field,
                        'item_id': itemId,
                        'status': isChecked ? 1 : 0,
                        '_token': '{{ csrf_token() }}'
                    });
                }
            });


            jQuery('.show-detail-contact').click(function () {
                let itemID = jQuery(this).data('contact-id');
                let callback = () => {
                    jQuery(this).addClass('btn-info').removeClass('btn-outline-info');
                }
                jQuery.get('{{ route('contacts.show') }}', {
                    item_id : itemID,
                }, function (data) {
                    jQuery('.modal-body').html(data);
                    jQuery('.modal').modal('show');
                    callback()
                });
            });
        })
    </script>
@endpush
