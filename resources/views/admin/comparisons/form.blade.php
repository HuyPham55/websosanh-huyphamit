<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            @if(count($lang) > 1)
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">
                            {{ __('label.language') }}
                        </a>
                    </li>
                    @foreach($lang as $langKey => $langTitle)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab"
                               href="#tab_lang_{{ $langKey }}">
                                {{ $langTitle }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <br>
            @endif
            <!-- Tab panes -->
            <div class="tab-content">
                @foreach($lang as $langKey => $langTitle)
                    <div id="tab_lang_{{ $langKey }}" class="tab-pane container p-0 {{ $loop->first ? 'active' : '' }}">

                        <div class="form-group">
                            <label class="control-label">{{ __('label.image') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            @includeIf('components.select_file', [
                                'keyId' => "image-{$langKey}",
                                'inputName' => "{$langKey}[image]",
                                'inputValue' => old("$langKey.image") ?? $post->image,
                                'lfmType' => 'image',
                                'note' => 'height x width',
                            ])
                        </div>

                        <div class="form-group">
                            <label for="{{ $langKey }}[title]"
                                   class="control-label">{{ __('label.title') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <input type="text" name="{{ $langKey }}[title]" id="{{ $langKey }}[title]"
                                   value="{{ old("$langKey.title") ?? $post->title }}"
                                   autocomplete="off" title=""
                                   class="form-control" maxlength="155">
                        </div>

                        <div class="form-group">
                            <label for="{{ $langKey }}[content]"
                                   class="control-label">{{ __('backend.content') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <textarea id="{{ $langKey }}[content]" name="{{ $langKey }}[content]"
                                      class="form-control tinymce" rows="25"
                            >{{ old("$langKey.content") ?? $post->content }}</textarea>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('components.form_elements.seo_single_language', ['data' => $post])


<div class="card-body">
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="category" class="control-label">
                    {{ __('label.category') }}
                </label>
                <select id="category" name="category" class="form-control select2" required>
                    @forelse($categories as $category_id => $category_title)
                        <option
                            value="{{ $category_id }}" {{ old('category') || request('category') == $category_id || $post->product_category_id == $category_id ? 'selected' : '' }}>
                            {{ $category_title }}
                        </option>
                    @empty
                        <option value="">{{ __('label.none')}}</option>
                    @endforelse
                </select>
                @error('category')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label" for="price">{{ __('label.price') }}</label>
                <input type="number" name="price" id="price" value="{{ old("price") ?? $post->price }}"
                       class="form-control" min="0" max="e9" placeholder="0">
            </div>
        </div>


    </div>
</div>
<div class="card-body">
    <div class="form-group mb-3">
        <label for="dropzone" class="form-label">Slides</label>
        <div id="dZUpload" class="dropzone bg-light shadow">
        </div>
    </div>
    <div class="row">
        @foreach($post->slide ?? [] as $photo)
            <div class="col-md-2 col-4 slide-item">
                <div class="card">
                    <a href="{{$photo}}" target="_blank">
                        <img class="card-img-top" src="{{ $photo }}" title="{{$photo}}">
                    </a>
                    <div class="card-footer">
                        <div class="row mb-3">
                            <input class="form-control update-card-image" type="text" name="slides[]" value="{{ $photo }}">
                        </div>
                        <div class="row justify-content-between">
                            <button class="btn-copy btn btn-primary" data-content="{{$photo}}" type="button">
                                <i class="fa fa-copy"></i>
                                {{trans('label.action.copy')}}
                            </button>
                            <button type="button" class="delete-photo btn btn-outline-danger">
                                <i class="fa fa-trash"></i>
                                {{trans('label.action.delete')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('label.image') }}</label>
        @includeIf('components.select_file', [
            'keyId' => "slides_string",
            'inputName' => "slides_string",
            'inputValue' => old("slides_string"),
            'lfmType' => 'image',
            'note' => 'height x width',
        ])
    </div>
</div>

<div class="card-body">
    <div class="row">
        @php
            $options = [
                'value' => $post->status ?? true,
                'label' => __('label.status.status'),
                'name' => 'status',
                ];
        @endphp
        @include('components.form_elements.mono_radio', $options)

        @php
            $options = [
                'value' => $post->featured ?? true,
                'label' => __('backend.featured'),
                'name' => 'featured',
                ];
        @endphp
        @include('components.form_elements.mono_radio', $options)

    </div>
</div>

<div class="card-footer">
    <div class="action-form">
        <div class="form-group mb-0 text-center">
            @includeIf('components.buttons.submit')
            @includeIf('components.buttons.cancel')
        </div>
    </div>
</div>
@include('components.tinymce')
@include('components.toastr')
@include('components.Select2')
@include('components.dropzone')
@push('css')
    <style>
        .card-img-top {
            width: 100%;
            height: 15vw;
            object-fit: cover;
        }
    </style>
@endpush
@push('js')
    <script>
        let dropzoneSelector = "#dZUpload"
        document.addEventListener('DOMContentLoaded', function () {
            let options = {
                url: "{{route("file.post_image")}}",
                headers: {
                    'x-csrf-token': '{{ csrf_token() }}',
                },
                paramName: 'image',
                parallelUploads: 3,
                addRemoveLinks: true,
                success: function (file, res) {
                    let data = res.data;
                    let path = data.path
                    let el = document.querySelector(dropzoneSelector);
                    if (!el) return

                    let div = document.createElement("div");
                    div.setAttribute("hidden", "true");
                    div.innerHTML = '<input name="slides[]"  value="' + path + '">'
                    el.append(div);
                    toastr.success(res.message);
                }
            }
            const dropzone = new Dropzone(dropzoneSelector, options);

            $(".delete-photo").on('click', function () {
                let slideItem = $(this).parents(".slide-item")
                slideItem.remove()
            });

            $(".btn-copy").on("click", function () {
                let url = $(this).data('content');
                navigator.clipboard.writeText(url)
                toastr.success(labels.status.success)
            })

            $(".update-card-image").on('change', function() {
                let newValue = $(this).val();
                let card = $(this).parents(".card").first();
                if (newValue.trim()) {
                    $(card).find("img.card-img-top").attr('src', newValue);
                }
            })
        })
    </script>
@endpush
