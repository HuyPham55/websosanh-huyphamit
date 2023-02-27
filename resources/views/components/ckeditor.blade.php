@push('js')
    <script type="text/javascript" src="{{ url('/editor/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        let options = {
            filebrowserImageBrowseUrl: '/admin/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Files&_token='
        }
        CKEDITOR.on("instanceReady", function (event) {
            event.editor.on("beforeCommandExec", function (event) {
                // Show the paste dialog for the paste buttons and right-click paste
                if (event.data.name === "paste") {
                    event.editor._.forcePasteDialog = true;
                }
                // Don't show the paste dialog for Ctrl+Shift+V
                if (event.data.name === "pastetext" && event.data.commandData.from === "keystrokeHandler") {
                    event.cancel();
                }
            })
        })
    </script>
    <script src="/editor/ckeditor/adapters/jquery.js"></script>
    <script>

        document.addEventListener("DOMContentLoaded", () => {
            jQuery('textarea.ckeditor').ckeditor(options);
        })
    </script>
@endpush

{{--Example id: id="ckeditor1{{$langKey}}"--}}


