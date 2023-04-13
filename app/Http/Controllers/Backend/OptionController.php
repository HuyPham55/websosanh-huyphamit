<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OptionController extends BaseController
{
    //
    private function optionKeys(): array
    {
        $optionKeys = [
            'site_favicon', 'site_logo', 'site_banner',
            'contact_hotline', 'contact_phone', 'contact_whatsapp_phone', 'contact_email',
            'social_facebook', 'social_twitter', 'social_instagram', 'emails_receive_notification',

            'footer_logo'
        ];

        $multiLangKeys = [
            'site_title', 'site_seo_title', 'site_description', 'contact_google_maps', 'contact_address', 'custom_code',
            'contact_email_reply_message',

        ];

        foreach ($multiLangKeys as $optionKey) {
            foreach (config('lang') as $langKey => $langTitle) {
                $optionKeys[] = "{$optionKey}_{$langKey}";
            }
        }

        return $optionKeys;
    }

    public function getEdit()
    {
        return view('admin.settings.options');
    }

    public function putEdit(Request $request)
    {
        foreach ($this->optionKeys() as $optionKey) {
            if ($request->has($optionKey)) {
                option([$optionKey => $request->input($optionKey)]);
                Cache::forget($optionKey);
            }
        }

        return back()->with(['status' => 'success', 'flash_message' => __('label.notification.success')]);
    }
}
