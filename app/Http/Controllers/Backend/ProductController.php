<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends BaseController
{
    //

    private Product $model;
    private string $routeList;
    private string $pathView;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Product();
        $this->routeList = 'products.list';
        $this->pathView = 'admin.products';
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
            ->filter(request()->all());
        $data = DataTables::eloquent($posts)
            ->editColumn('image', function ($item) {
                return either($item->image, '/images/no-image.png');
            })
            ->editColumn('title', function ($item) {
                return $item->title;
            })
            ->editColumn('status', function ($item) {
                return view('components.buttons.bootstrapSwitch', [
                    'data' => $item,
                    'permission' => 'edit_products',
                ]);
            })
            ->editColumn('created_at', function ($item) {
                return $item->date_format;
            })
            ->addColumn('action', function ($item) {
                return view('components.buttons.edit', ['route' => route('products.edit', ['id' => $item->id])])
                    . ' ' .
                    view('components.buttons.delete', ['route' => route('products.delete'), 'id' => $item->id]);
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
}
