<div class="card-body">
    <div class="form-group row">
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
                                'inputValue' => old("$langKey.image") ?? $page->getTranslation('image', $langKey),
                                'lfmType' => 'image',
                                'note' => 'height x width',
                            ])
                        </div>

                        <div class="form-group">
                            <label for="{{ $langKey }}[title]"
                                   class="control-label">{{ __('label.title') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <input type="text" name="{{ $langKey }}[title]" id="{{ $langKey }}[title]"
                                   value="{{ old("$langKey.title") ?? $page->getTranslation('title', $langKey) }}"
                                   autocomplete="off" title=""
                                   class="form-control" maxlength="155">
                        </div>

                        <div class="form-group">
                            <label for="{{ $langKey }}[content]"
                                   class="control-label">{{ __('backend.content') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <textarea id="{{ $langKey }}[content]" name="{{ $langKey }}[content]"
                                      class="form-control tinymce" rows="25"
                            >{{ old("$langKey.content") ?? $page->getTranslation('content', $langKey) }}</textarea>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('components.form_elements.seo', ['data' => $page])


<div class="card-footer">
    <div class="action-form">
        <div class="form-group mb-0 text-center">
            @includeIf('components.buttons.submit')
            @includeIf('components.buttons.cancel')
        </div>
    </div>
</div>

@include('components.tinymce')

