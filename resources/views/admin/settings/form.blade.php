<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('label.logo') }}</label>
                @includeIf('components.select_file', [
                    'keyId' => "site_logo",
                    'inputName' => "site_logo",
                    'inputValue' => old("site_logo") ?? option('site_logo'),
                    'lfmType' => 'image',
                    'note' => 'height x width',
                ])
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('backend.favicon') }}</label>
                @includeIf('components.select_file', [
                    'keyId' => "site_favicon",
                    'inputName' => "site_favicon",
                    'inputValue' => old("site_favicon") ?? option('site_favicon'),
                    'lfmType' => 'image',
                    'note' => 'height x width',
                ])
            </div>
        </div>
    </div>

</div>

<hr>

<div class="card-body">
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label for="contact_hotline" class="control-label">{{trans('backend.contact_hotline')}}</label>
                <input type="text" name="contact_hotline" id="contact_hotline" maxlength="155" autocomplete="off"
                       value="{{ old('contact_hotline') ?? option('contact_hotline') }}"
                       class="form-control">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="contact_phone" class="control-label">{{trans('backend.contact_phone')}}</label>
                <input type="text" name="contact_phone" id="contact_phone" maxlength="155" autocomplete="off"
                       value="{{ old('contact_phone') ?? option('contact_phone') }}"
                       class="form-control">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="contact_email" class="control-label">{{trans('backend.contact_email')}}</label>
                <input type="email" name="contact_email" id="contact_email" maxlength="155" autocomplete="off"
                       value="{{ old('contact_email') ?? option('contact_email') }}" class="form-control">
            </div>
        </div>

    </div>
</div>


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
                    <div id="tab_lang_{{ $langKey }}"
                         class="tab-pane container p-0 {{ $loop->first ? 'active' : '' }}">

                        <div class="form-group">
                            <label for="{{ $langKey }}[title]"
                                   class="control-label">{{ __('label.title') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <input type="text" name="site_title_{{ $langKey }}" id="{{ $langKey }}[title]"
                                   value="{{ old("site_title_$langKey") ?? option("site_title_$langKey") }}"
                                   autocomplete="off" title=""
                                   class="form-control" maxlength="155">
                        </div>

                        <div class="form-group">
                            <label for="{{ $langKey }}[seo_title]"
                                   class="control-label">{{ __('backend.seo.title') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <input type="text" name="site_seo_title_{{ $langKey }}" id="{{ $langKey }}[seo_title]"
                                   value="{{ old("site_seo_title_$langKey") ?? option("site_seo_title_$langKey") }}"
                                   autocomplete="off"
                                   class="form-control" maxlength="155">
                        </div>

                        <div class="form-group">
                            <label for="{{ $langKey }}[site_description]"
                                   class="control-label">{{ __('backend.seo.description') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <textarea id="{{ $langKey }}[site_description]" name="site_description_{{ $langKey }}"
                                      class="form-control" rows="5" maxlength="300"
                            >{{ old("site_description_$langKey") ?? option("site_description_$langKey") }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="{{ $langKey }}[contact_email_reply_message]"
                                   class="control-label">{{ __('label.contact_email_reply_message') }} {{ count($lang) > 1 ? "($langTitle)" : '' }}</label>
                            <input type="text" name="contact_email_reply_message_{{ $langKey }}" id="{{ $langKey }}[contact_email_reply_message]"
                                   value="{{ old("contact_email_reply_message_$langKey") ?? option("contact_email_reply_message_$langKey") }}"
                                   autocomplete="off"
                                   placeholder="{{trans('frontend.contact_success_message')}}"
                                   class="form-control" maxlength="155">
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<hr>
<div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="social_facebook" class="control-label">Facebook</label>
                <input type="text" name="social_facebook" id="social_facebook"
                       value="{{ old('social_facebook') ?? option('social_facebook') }}"
                       class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="social_twitter" class="control-label">Twitter</label>
                <input type="text" name="social_twitter" id="social_twitter"
                       value="{{ old('social_twitter') ?? option('social_twitter') }}"
                       class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="social_instagram" class="control-label">Instagram</label>
                <input type="text" name="social_instagram" id="social_instagram"
                       value="{{ old('social_instagram') ?? option('social_instagram') }}"
                       class="form-control">
            </div>
        </div>
    </div>
</div>

<div class="card-body">

    @if(count($lang) > 1)
        <ul class="nav nav-tabs">
            @foreach($lang as $langKey => $langTitle)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab"
                       href="#tab_custom_code_lang_{{ $langKey }}">
                        {{ $langTitle }}
                    </a>
                </li>
            @endforeach
        </ul>
        <br>
    @endif

    <div class="tab-content">
        @foreach($lang as $langKey => $langTitle)
            <div id="tab_custom_code_lang_{{ $langKey }}"
                 class="tab-pane container p-0 {{ $loop->first ? 'active' : '' }}">

                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label" for="custom_code_{{ $langKey }}">{{trans('backend.custom_code')}}
                            ({{ $langTitle }})</label>
                        <div class="form-group">
                                <textarea class="form-control textarea_custom_code" id="custom_code_{{ $langKey }}"
                                          rows="10" data-lang="{{ $langKey }}"
                                >{{ base64_decode(old("custom_code_$langKey") ?? option("custom_code_$langKey")) }}</textarea>
                            <input type="hidden" id="custom_code_{{ $langKey }}" name="custom_code_{{ $langKey }}"
                                   value="{{option("custom_code_$langKey")}}">
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
</div>

<hr>

@can('setting_email_notification')
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="emails_receive_notification">{{ trans('backend.email_notification') }}</label>
                    <input type="text" name="emails_receive_notification"
                           id="emails_receive_notification"
                           value="{{ old('emails_receive_notification') ?? option('emails_receive_notification') }}"
                           class="form-control tags" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
@endcan

<div class="card-footer">
    <div class="action-form">
        <div class="form-group mb-0 text-center">
            @includeIf('components.buttons.submit')
            @includeIf('components.buttons.cancel')
        </div>
    </div>
</div>

@include('components.Select2')
@include('components.tags')
@push('js')
    <script>
        jQuery(() => {
            jQuery(".textarea_custom_code").on("input", function () {
                let changingLang = jQuery(this).data('lang');
                if (changingLang) {
                    jQuery(`input#custom_code_${changingLang}`).val(btoa($(this).val()));
                }
            });

            $('input.tags').tagsinput({
                trimValue: true
            });
        })
    </script>
@endpush
