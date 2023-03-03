<hr>
<div class="card-body">
    <div class="form-row">
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
                               href="#tab_seo_{{ $langKey }}">
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
                    <div id="tab_seo_{{ $langKey }}" class="tab-pane container p-0 {{ $loop->first ? 'active' : '' }}">
                        <div class="form-group">
                            <label for="{{ $langKey }}[seo_title]"
                                   class="control-label">{{ __('backend.seo.title') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <input type="text" name="{{ $langKey }}[seo_title]" id="{{ $langKey }}[seo_title]"
                                   value="{{ old("$langKey.title") ?? $data->getTranslation('seo_title', $langKey) }}"
                                   autocomplete="off"
                                   class="form-control" maxlength="155">
                        </div>
                        <div class="form-group">
                            <label for="{{ $langKey }}[seo_description]"
                                   class="control-label">{{ __('backend.seo.description') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <textarea name="{{ $langKey }}[seo_description]" id="{{ $langKey }}[seo_description]" class="form-control" rows="5" maxlength="300"
                            >{{ old("$langKey.description") ?? $data->getTranslation('seo_description', $langKey) }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


