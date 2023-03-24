<?php

namespace App\Http\Controllers;

use App\Enums\CommonStatus;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SlideResource;
use App\Models\ProductCategory;
use App\Models\Slide;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.dashboard');
//        return view('home');
    }

    public function fetchLayoutData(Request $request)
    {
        return response()->json([
            'title' => cachedOption('site_title_' . app()->getLocale()),
            'footerData' => [
                'slides' => $this->getFooterSlides(),
                'logo' => cachedOption("footer_logo"),
                'contact_address' => cachedOption('contact_address_' . app()->getLocale()),
                'contact_hotline' => cachedOption('contact_hotline'),
                'contact_email' => cachedOption('contact_email')
            ],
            'headerData' => [
                'menuItems' => $this->getMenuItems(),
                'logo' => cachedOption('site_logo')
            ]
        ]);
    }

    private function getFooterSlides()
    {
        $collection = Slide::where('key', 'FOOTER_SLIDES')
            ->orderBy('sorting')
            ->orderBy('id')
            ->get();
        return SlideResource::collection($collection);
    }

    private function getMenuItems()
    {
        $collection = ProductCategory::where([
            ['status', CommonStatus::Active],
            ['is_shown_on_menu', CommonStatus::Active]
        ])
            ->orderBy('sorting')
            ->get();
        $nestedCollection = (new CategoryService(new ProductCategory()))->nestedMenu($collection);
        return CategoryResource::collection($nestedCollection);
    }
}
