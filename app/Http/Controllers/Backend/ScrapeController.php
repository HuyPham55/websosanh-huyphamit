<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScrapeRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Scrape;
use App\Models\Seller;
use App\Services\CategoryService;
use App\Services\ScrapeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class ScrapeController extends BaseController
{
    //

    private Scrape $model;
    private string $routeList;
    private string $pathView;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Scrape();
        $this->routeList = 'scrapes.list';
        $this->pathView = 'admin.scrapes';
    }

    public function index()
    {
        session(['url.intended' => url()->full()]);

        $categories = (new CategoryService(new ProductCategory()))->dropdown();

        return view("{$this->pathView}.list", compact('categories'));
    }

    public function datatables(Request $request)
    {
        $posts = $this->model
            ->withCount('products')
            ->filter(request()->all());
        $data = DataTables::eloquent($posts)
            ->editColumn('url', function ($item) {
                $productCount = $item->products_count;
                return $item->url." ({$productCount})";
            })
            ->editColumn('created_at', function ($item) {
                return $item->date_format;
            })
            ->addColumn('action', function ($item) {
                return view('components.buttons.edit', ['route' => route('scrapes.edit', ['id' => $item->id])])
                    . ' ' .
                    view('components.buttons.delete', ['route' => route('scrapes.delete'), 'id' => $item->id]);
            })
            ->setRowId(function ($item) {
                return 'row-id-' . $item->id;
            });
        return $data->toJson();
    }


    public function getAdd()
    {
        $post = $this->model;

        return view("{$this->pathView}.add", compact('post'));
    }

    public function postAdd(Request $request)
    {
        $flag = $this->model::saveModel($this->model, $request, editFlag: false);
        if (!$flag instanceof \Exception) {
            return redirect()->route($this->routeList)->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
        } else {
            return redirect()->back()
                ->withInput()
                ->with([
                    'status' => 'danger',
                    'flash_message' => env('APP_DEBUG') ? $flag->getMessage() : trans('label.something_went_wrong')
                ]);
        }
    }

    public function getEdit(int $id)
    {
        $post = $this->model::findOrFail($id);

        return view("{$this->pathView}.edit", compact('post'));
    }

    public function putEdit(Request $request, int $id)
    {
        $post = $this->model::findOrFail($id);
        $flag = $this->model::saveModel($post, $request, editFlag: true);
        if ($flag instanceof \Exception) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'status' => 'danger',
                    'flash_message' => env("APP_DEBUG") ? $flag->getMessage() : trans('label.something_went_wrong')
                ]);
        }
        return redirect()->intended(route($this->routeList))->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
    }

    public function delete(Request $request)
    {
        $post = $this->model::findOrFail($request->post('item_id'));
        $flag = $post->delete();
        if ($flag) {
            return response()->json([
                'status' => 'success',
                'title' => trans('label.deleted'),
                'message' => trans('label.notification.success')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'title' => trans('label.error'),
            'message' => trans('label.something_went_wrong')
        ]);
    }

    public function ApiValidateUrl(ScrapeRequest $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);
    }


    public function ApiFetchModelData(Request $request)
    {
        $categories = (new CategoryService(new ProductCategory()))->dropdown_associated();
        $sellers = Seller::select('id', 'title', 'status')->get();
        $model = $this->model->find($request->input('id'));
        //$model can be null
        $products = $model === null
            ? []
            : $model->products()->get();
        return response()->json([
            'model' => $model,
            'categories' => $categories,
            'sellers' => $sellers,
            'products' => $products,
        ]);
    }

    public function ApiGetScrapedData(Request $request)
    {
        //iframe data
        return Cache::get('scraping_url');
    }

    public function ApiScrapeHtml(Request $request)
    {
        $url = $request->input('url');
        $scraper = new ScrapeService();
        $result = $scraper->scrape($url);
        $html = $result['html'];
        Cache::put('scraping_url', $html);
        return $html;
    }
}
