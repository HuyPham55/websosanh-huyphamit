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
                                'inputValue' => old("$langKey.image") ?? $slide->getTranslation('image', $langKey),
                                'lfmType' => 'image',
                                'note' => 'height x width',
                            ])
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label for="{{ $langKey }}[url]"
                                       class="control-label">{{ __('label.url') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                                <input type="text" name="{{ $langKey }}[url]" id="{{ $langKey }}[url]"
                                       value="{{ old("$langKey.url") ?? $slide->getTranslation('url', $langKey) }}"
                                       class="form-control" maxlength="255" autocomplete="off">
                            </div>

                            <label for="{{ $langKey }}[text_1]"
                                   class="control-label">{{ __('label.title') }}
                                1 {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <input type="text" name="{{ $langKey }}[text_1]" id="{{ $langKey }}[text_1]"
                                   value="{{ old("$langKey.text_1") ?? $slide->getTranslation('text_1', $langKey) }}"
                                   autocomplete="off" title=""
                                   class="form-control" maxlength="155">
                        </div>
                        <div class="form-group">
                            <label for="{{ $langKey }}[text_2]"
                                   class="control-label">{{ __('label.title') }}
                                2 {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <input type="text" name="{{ $langKey }}[text_2]" id="{{ $langKey }}[text_2]"
                                   value="{{ old("$langKey.text_2") ?? $slide->getTranslation('text_2', $langKey) }}"
                                   autocomplete="off" title=""
                                   class="form-control" maxlength="155">
                        </div>
                        <div class="form-group">
                            <label for="{{ $langKey }}[text_3]"
                                   class="control-label">{{ __('label.title') }}
                                3 {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <input type="text" name="{{ $langKey }}[text_3]" id="{{ $langKey }}[text_3]"
                                   value="{{ old("$langKey.text_3") ?? $slide->getTranslation('text_3', $langKey) }}"
                                   autocomplete="off" title=""
                                   class="form-control" maxlength="155">
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


<div class="card-body">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label" for="sorting">{{ __('backend.sorting') }}</label>
                <input type="number" name="sorting" id="sorting" value="{{ old("sorting") ?? $slide->sorting }}"
                       class="form-control" min="0" max="e9" placeholder="0">
            </div>
        </div>


        @php
            $options = [
                'value' => $slide->status ?? true,
               'label' => __('label.status.status'),
               'name' => 'status',
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

