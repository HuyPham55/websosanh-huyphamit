<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Services\CategoryService;
use App\Services\NestedSetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogCategoryController extends BaseController
{
    //
    private CategoryService $categoryService;
    private string $pathView;
    private string $routeList;
    private BlogCategory $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new BlogCategory();
        $this->categoryService = new CategoryService(new BlogCategory());
        $this->routeList = 'blog_categories.list';
        $this->pathView = 'admin.blog.categories';
    }

    public function index()
    {
        session(['url.intended' => url()->full()]);
        $categories = $this->model
            ->withCount('posts')
            ->orderBy('sorting')
            ->orderBy('id')
            ->get();
        $categories = $this->categoryService->nestedMenu($categories);
        return view("{$this->pathView}.list", compact('categories'));
    }

    public function getAdd()
    {
        $category = new BlogCategory();
        $categories = $this->categoryService->dropdown(trans('label.root_category'));

        return view("{$this->pathView}.add", compact('categories', 'category'));
    }

    public function postAdd(Request $request)
    {
        $flag = $this->model->saveModel(new BlogCategory(), $request);
        if ($flag) {
            return redirect()->route($this->routeList)->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
        }
        return redirect()->back()->with([
            'status' => 'danger',
            'flash_message' => trans('label.something_went_wrong')
        ]);
    }

    public function getEdit(int $id)
    {
        $category = BlogCategory::findOrFail($id);
        $categories = $this->categoryService->dropdown(trans('label.root_category'), $id);

        return view("{$this->pathView}.edit", compact('category', 'categories'));
    }

    public function putEdit(Request $request, int $id)
    {
        $category = BlogCategory::findOrFail($id);
        $flag = $this->model->saveModel($category, $request);
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
        $id = $request->post('item_id');
        DB::beginTransaction();
        try {
            $category = BlogCategory::findOrFail($id);
            $subCategories = $this->categoryService->getArrayChildrenId($category->lft, $category->rgt);

            //delete all categories where id in $subCategories
            foreach (BlogCategory::whereIn('id', $subCategories)->get() as $category) {
                $category->delete();
            }

            //delete translations

            //Nested model again
            $nestedSetService = new NestedSetService($this->model->getTable());
            $nestedSetService->doNested();

            // delete all posts where category_id in $subCategories

            DB::commit();

            return response()->json([
                'status' => 'success',
                'title' => trans('label.deleted'),
                'message' => trans('label.notification.success')
            ]);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'title' => trans('label.error'),
                'message' => trans('label.something_went_wrong')
            ]);
        }
    }

    public function changeSorting(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required|integer',
            'sorting' => 'integer|min:0|nullable',
        ]);

        $modelId = $request->post('item_id');
        $sorting = $request->post('sorting');

        $model = $this->model->findOrFail($modelId);
        $model->sorting = $sorting;
        $model->save();
        return response()->json([
            'status' => 'success',
            'message' => __('label.notification.success')
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
                'reload' => true,
                'message' => __('label.notification.success')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => trans('label.something_went_wrong')
        ]);
    }

}
