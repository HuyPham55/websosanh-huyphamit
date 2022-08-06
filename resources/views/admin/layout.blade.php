@extends('adminlte::page')
@push('js')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script type="text/javascript">
        let labels = {
            cancel: '{{trans('label.action.cancel')}}',
            status: {
                canceled: '{{trans('label.status.canceled')}}',
            },
            action: {
                confirm_action: '{{trans('label.action.confirm_action')}}',
            }
        }

        $('.lfm-image').filemanager('image');
        $('.lfm-file').filemanager('file');
    </script>
    <script src="{{asset('/backend/js/backend.js')}}"></script>
@endpush
@section('plugins.Sweetalert2', true)
