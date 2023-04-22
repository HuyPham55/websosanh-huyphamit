<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\CommonStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\BlogPost;
use App\Models\StaticPage;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    //
    use HttpResponses;
    public function getAboutPage(Request $request)
    {
        $key = 'about_page';
        $page = StaticPage::firstOrCreate(['key' => $key]);
        return $this->success([
            'model' => new PostResource($page),
            'related' => $this->getRelatedPosts()
        ]);
    }
    private function getRelatedPosts()
    {
        $posts = BlogPost::where([
            ['status', CommonStatus::Active]
        ])
            ->take(7)
            ->get();
        return PostResource::collection($posts)->response()->getData(true);
    }

}
