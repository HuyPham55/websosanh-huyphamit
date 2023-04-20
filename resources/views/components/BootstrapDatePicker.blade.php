@push('css')
    <link href="/backend/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endpush
@push('js')
    <script src="/backend/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
@endpush
{{--Sample usage--}}
{{--
<script type="text/javascript">
    jQuery(() => {
        jQuery(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });
    })
</script>
--}}
