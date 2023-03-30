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

@include('components.Select2')
