{{--Include CSS and JS files for the plugin--}}
@section('plugins.Select2', true)
@push("js")
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $('select.select2').select2({
                theme: "classic",
            });
        })
    </script>
@endpush
