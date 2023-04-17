@push('css')
    <link rel="stylesheet" href="/editor/trumbowyg/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="/editor/trumbowyg/plugins/colors/ui/trumbowyg.colors.css">
@endpush
@push('js')
    <script src="{{url('/plugins/trumbowyg/trumbowyg.min.js')}}"></script>
    <script src="/editor/trumbowyg/plugins/colors/trumbowyg.colors.min.js"></script>
    <script src="/editor/trumbowyg/plugins/fontsize/trumbowyg.fontsize.min.js"></script>
    <script>
        $('.trumbowyg').trumbowyg({
            btns: [
                ['strong', 'em', 'underline'],
                ['foreColor', 'backColor'],
                ['fontsize'],
                ['removeformat'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ],
            tagsToRemove: ['script', 'link'],
            resetCss: true,
            autogrow: true
        });
    </script>
@endpush
