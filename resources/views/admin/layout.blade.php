@extends('adminlte::page')
@push('js')
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
    </script>
    <script src="{{asset('/backend/js/backend.js')}}"></script>
@endpush
@section('plugins.Sweetalert2', true)
