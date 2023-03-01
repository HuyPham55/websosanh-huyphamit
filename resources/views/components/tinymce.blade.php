<!-- TinyMCE JS -->
<script src="{{ url('/editor/tinymce/tinymce.min.js') }}"></script>
<script>
    const editor_config = {
        selector: '.tinymce',
        height: "500px",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools codesample"
        ],
        toolbar1: "insertfile undo redo | formatselect | fontsizeselect | styleselect | bold italic underline strikethrough removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
        toolbar2: "print preview | forecolor backcolor | emoticons | link unlink anchor | image media | code codesample",
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        image_caption: true,
        media_live_embeds: true,
        imagetools_cors_hosts: ['tinymce.com', 'codepen.io'],
        image_advtab: true,
        relative_urls: false,
        forced_root_block: false,
        file_picker_callback: function (callback, value, meta) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = '/filemanager?editor=' + meta.fieldname;
            if (meta.filetype === 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.openUrl({
                url: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    };


    document.addEventListener("DOMContentLoaded", () => {
        tinymce.init(editor_config);
    })
</script>
