<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comparison;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\CategoryService;
use App\Services\ElasticService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ComparisonController extends BaseController
{
    //

    private Comparison $model;
    private string $routeList;
    private string $pathView;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Comparison();
        $this->routeList = 'comparisons.list';
        $this->pathView = 'admin.comparisons';
    }

    public function index()
    {
        session(['url.intended' => url()->full()]);

        $categories = (new CategoryService(new ProductCategory()))->dropdown();
        $total_count = $this->model->count();

        try {
            $client = new ElasticService($this->model->getTable());
            if (!$client->indexExist()) {
                $client->createIndex();
            }
        } catch (\Exception $exception) {
            return view("{$this->pathView}.list", compact('categories', 'total_count'))
                ->with(['danger' => 'success', 'flash_message' => $exception->getMessage()]);
        }

        return view("{$this->pathView}.list", compact('categories', 'total_count'));
    }

    public function datatables(Request $request)
    {
        $posts = $this->model
            ->withCount('products')
            ->filter(request()->all());
        $data = DataTables::eloquent($posts)
            ->editColumn('image', function ($item) {
                return either($item->image, '/images/no-image.png');
            })
            ->editColumn('title', function ($item) {
                $productCount = $item->products_count;
                return $item->title." ({$productCount})";
            })
            ->editColumn('status', function ($item) {
                return view('components.buttons.bootstrapSwitch', [
                    'data' => $item,
                    'permission' => 'edit_comparisons',
                ]);
            })
            ->editColumn('created_at', function ($item) {
                return $item->date_format;
            })
            ->addColumn('action', function ($item) {
                $views = view('components.buttons.edit', ['route' => route('comparisons.edit', ['id' => $item->id])]);
                if (auth()->guard('web')->user()->can('show_list_products')) {
                    $views .= view('components.buttons.view', ['route' => route('comparisons.show', ['id' => $item->id])]);
                }
                $views .= view('components.buttons.delete', ['route' => route('comparisons.delete'), 'id' => $item->id]);
                return $views;
            })
            ->setRowId(function ($item) {
                return 'row-id-' . $item->id;
            });
        return $data->toJson();
    }


    public function getAdd()
    {
        $post = $this->model;
        $categories = (new CategoryService(new ProductCategory()))->dropdown();

        return view("{$this->pathView}.add", compact('post', 'categories'));
    }

    public function postAdd(Request $request)
    {
        $flag = $this->model::saveModel($this->model, $request);
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
        $categories = (new CategoryService(new ProductCategory()))->dropdown();

        return view("{$this->pathView}.edit", compact('post', 'categories'));
    }

    public function putEdit(Request $request, int $id)
    {
        $post = $this->model::findOrFail($id);
        $flag = $this->model::saveModel($post, $request);
        if ($flag) {
            return redirect()->intended(route($this->routeList))->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
        }
        return redirect()->back()->with([
            'status' => 'danger',
            'flash_message' => trans('label.something_went_wrong')
        ]);
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

    public function changeStatus(Request $request)
    {
        $this->validate($request, [
            'field' => 'required|in:status',
            'item_id' => 'required|integer',
            'status' => 'required|integer',
        ]);

        $field = $request->post('field');
        $itemId = $request->post('item_id');
        $status = $request->post('status');

        if (in_array($status, [0, 1])) {
            $model = $this->model->findOrFail($itemId);
            $model->{$field} = $status;
            $model->save();

            return response()->json([
                'status' => 'success',
                'message' => __('label.notification.success')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => trans('label.something_went_wrong')
        ]);
    }

    public function changePopular(Request $request)
    {
        $this->validate($request, [
            'field' => 'required|in:is_popular',
            'item_id' => 'required|integer',
            'is_popular' => 'required|integer',
        ]);

        $field = $request->post('field');
        $itemId = $request->post('item_id');
        $is_popular = $request->post('is_popular');

        if (in_array($is_popular, [0, 1])) {
            $model = $this->model->findOrFail($itemId);
            $model->{$field} = $is_popular;
            $model->save();

            return response()->json([
                'status' => 'success',
                'message' => __('label.notification.success')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => trans('label.something_went_wrong')
        ]);
    }

    public function changeSorting(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required|integer',
            'sorting' => 'required|integer',
        ]);

        try {
            $model = $this->model->findOrFail($request->item_id);
            $model->sorting = $request->sorting;
            $model->save();

            return response()->json([
                'status' => 'success',
                'message' => __('label.notification.success')
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => trans('label.something_went_wrong')
            ]);
        }
    }

    public function getShow(Request $request, $id)
    {
        $model = $this->model->findOrFail($id);
        return view("{$this->pathView}.list_products", compact('model'));
    }

    public function productDatatables(Request $request, $id)
    {
        $posts = $this->model->with('products')->findOrFail($id)->products;
        $arrProductIds = $posts->modelKeys() ?? [];
        $productCollection = Product
            ::with(['seller'])
            ->get();
        $data = DataTables::make($productCollection)
            ->editColumn('image', function ($item) {
                return either($item->image, '/images/no-image.png');
            })
            ->editColumn('title', function ($item) {
                return $item->title;
            })
            ->editColumn('status', function ($item) use ($arrProductIds) {
                $data = new \stdClass();
                $data->id = $item->id;
                $data->status = in_array($item->id, $arrProductIds);
                return view('components.buttons.bootstrapSwitch', [
                    'data' => $data,
                    'permission' => 'edit_comparisons',
                ]);
            })
            ->editColumn('created_at', function ($item) {
                return $item->date_format;
            })
            ->addColumn('seller', function ($item) {
                return $item->seller->title;
            })
            ->setRowId(function ($item) {
                return 'row-id-' . $item->id;
            });
        return $data->toJson();
    }

    public function productChangeRelationship(Request $request, $id)
    {
        $this->validate($request, [
            'field' => 'required|in:status',
            'item_id' => 'required|integer',
            'status' => 'required|integer',
        ]);

        $itemId = $request->post('item_id');
        $status = $request->post('status');

        $comparison = $this->model->with(['products'])->findOrFail($id);
        if (in_array($status, [0, 1])) {
            if ($status) {
                $comparison->products()->attach($itemId);
                $this->updateModelData($comparison);
            } else {
                $comparison->products()->detach($itemId);
            }

            return response()->json([
                'status' => 'success',
                'message' => __('label.notification.success')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => trans('label.something_went_wrong')
        ]);
    }

    public function addAllToIndex(Request $request) {
        try {
            $client = new ElasticService($this->model->getTable());
            $collection = Comparison::get()->toArray();
            $sizeLimit = 100;
            $client->bulkIndex($collection, $sizeLimit);
            return redirect()->intended(route($this->routeList))->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
        } catch (\Exception $exception) {
            return redirect()->back()->with([
                'status' => 'danger',
                'flash_message' => $exception->getMessage()
            ]);
        }
    }
    public function clearIndex(Request $request) {
        try {
            $client = new ElasticService($this->model->getTable());
            $client->deleteIndex();
            return redirect()->intended(route($this->routeList))->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
        } catch (\Exception $exception) {
            return redirect()->back()->with([
                'status' => 'danger',
                'flash_message' => $exception->getMessage()
            ]);
        }
    }

    protected function updateModelData(mixed $comparison)
    {
        $product = $comparison->products()->orderBy('price')->take(1)->first();
        if ($product === null) {
            return;
        }
        $comparison->price = $product->price | 0;
        if (empty($comparison->image)) {
            $comparison->image = $product->image;
        }
        $comparison->save();
    }

    public function getShowActive(Request $request, $id)
    {
        $model = $this->model->findOrFail($id);
        return view("{$this->pathView}.list_active_products", compact('model'));
    }
    public function activeProductsDatatables(Request $request, $id)
    {
        $posts = $this->model->findOrFail($id);
        $productCollection = $posts->products()->with(['seller']);
        $data = DataTables::eloquent($productCollection)
            ->editColumn('image', function ($item) {
                return either($item->image, '/images/no-image.png');
            })
            ->editColumn('title', function ($item) {
                return $item->title;
            })
            ->editColumn('created_at', function ($item) {
                return $item->date_format;
            })
            ->addColumn('seller', function ($item) {
                return $item->seller->title;
            })
            ->setRowId(function ($item) {
                return 'row-id-' . $item->id;
            });
        return $data->toJson();
    }
}
