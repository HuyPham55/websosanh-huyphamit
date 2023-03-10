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
                            <label
                                class="control-label">{{ __('label.image') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            @includeIf('components.select_file', [
                                'keyId' => "image-{$langKey}",
                                'inputName' => "{$langKey}[image]",
                                'inputValue' => old("$langKey.image") ?? $category->image,
                                'lfmType' => 'image',
                                'note' => 'height x width',
                            ])
                        </div>


                        <div class="form-group">
                            <label
                                class="control-label">{{ __('label.banner') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            @includeIf('components.select_file', [
                                'keyId' => "banner-{$langKey}",
                                'inputName' => "{$langKey}[banner]",
                                'inputValue' => old("$langKey.banner") ?? $category->banner,
                                'lfmType' => 'image',
                                'note' => 'height x width',
                            ])
                        </div>


                        <div class="form-group">
                            <label
                                class="control-label">{{ __('label.icon') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            @includeIf('components.select_file', [
                                'keyId' => "icon-{$langKey}",
                                'inputName' => "{$langKey}[icon]",
                                'inputValue' => old("$langKey.icon") ?? $category->icon,
                                'lfmType' => 'image',
                                'note' => 'height x width',
                            ])
                        </div>

                        <div class="form-group">
                            <label for="{{ $langKey }}[title]"
                                   class="control-label">{{ __('label.title') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <input type="text" name="{{ $langKey }}[title]" id="{{ $langKey }}[title]"
                                   value="{{ old("$langKey.title") ?? $category->title }}"
                                   autocomplete="off"
                                   class="form-control" maxlength="155">
                        </div>

                        <div class="form-group">
                            <label for="{{ $langKey }}[content]"
                                   class="control-label">{{ __('backend.content') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <textarea id="{{ $langKey }}[content]" name="{{ $langKey }}[content]"
                                      class="form-control tinymce" rows="25"
                            >{{ old("$langKey.content") ?? $category->content }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('components.form_elements.seo_single_language', ['data' => $category])

<div class="card-body">
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="parent_category" class="control-label">{{ __('label.parent_category') }}</label>
                <select id="parent_category" class="form-control select2" name="parent_category" required>
                    @foreach($categories as $cat_id => $cat_name)
                        <option value="{{ $cat_id }}" {{ old('parent_category') == $cat_id || $category->parent_id == $cat_id ? 'selected' : '' }}>
                            {!! $cat_name !!}
                        </option>
                    @endforeach
                </select>
                @error('parent_category')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label" for="sorting">{{ __('backend.sorting') }}</label>
                <input type="number" name="sorting" id="sorting" value="{{ old("sorting") ?? $category->sorting }}"
                       class="form-control" min="0" max="e9" placeholder="0">
            </div>
        </div>

    </div>
</div>
<div class="card-body">
    <div class="row">

        @php
            $options = [
                'value' => $category->status ?? true,
                'label' => __('label.status.status'),
                'name' => 'status',
                ];
        @endphp
        @include('components.form_elements.mono_radio', $options)

        @php
            $options = [
                'value' => $category->is_shown_on_menu ?? true,
                'label' => __('backend.is_shown_on_menu'),
                'name' => 'is_shown_on_menu',
                ];
        @endphp
        @include('components.form_elements.mono_radio', $options)

        @php
            $options = [
                'value' => $category->featured ?? true,
                'label' => __('backend.featured'),
                'name' => 'featured',
                ];
        @endphp
        @include('components.form_elements.mono_radio', $options)

        @php
            $options = [
                'value' => $category->is_popular ?? true,
                'label' => __('backend.is_popular'),
                'name' => 'is_popular',
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
@include('components.Select2')
@push('js')
    @vite(['resources/js/backend/app.js'])
@endpush
