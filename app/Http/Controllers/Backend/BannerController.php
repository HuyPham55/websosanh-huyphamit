<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BannerController extends BaseController
{
    //
    private array $optionKeys;

    public function __construct()
    {
        parent::__construct();

        $this->optionKeys = [
            'banner_contact_us' => [
                'label' => trans('frontend.contact_us'),
                'note' => 'width x height',
            ],
            'banner_about_us' => [
                'label' => trans('frontend.about_us'),
                'note' => '',
            ],
            'faq_banner' => [
                'label' => __('label.faqs'),
                'note' => '',
            ],
        ];
    }

    public function getEdit(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.settings.banners', ['bannerKeys' => $this->optionKeys]);
    }

    public function postEdit(Request $request): \Illuminate\Http\RedirectResponse
    {
        foreach ($this->optionKeys as $optionKey => $optionTitle) {
            if ($request->has($optionKey)) {
                option([$optionKey => $request->input($optionKey)]);
                Cache::forget($optionKey);
            }
        }

        return back()->with(['status' => 'success', 'flash_message' => __('label.notification.update_success')]);
    }
}
