<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends BaseController
{
    //
    private string $pathView;
    private string $routeList;
    private Faq $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Faq();
        $this->routeList = 'faqs.list';
        $this->pathView = 'admin.faqs';
    }

    public function index(Request $request)
    {
        session(['url.intended' => url()->full()]);
        $posts = $this->model
            ::filter($request->all())
            ->orderBy('sorting')
            ->orderBy('id')
            ->paginate();

        return view("{$this->pathView}.list", compact('posts'));
    }

    public function getAdd()
    {
        return view("{$this->pathView}.add", ['post' => $this->model]);
    }

    public function postAdd(Request $request)
    {
        $flag = $this->model::saveModel($this->model, $request);
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
        $post = $this->model::findOrFail($id);

        return view("{$this->pathView}.edit", ['post' => $post]);
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
                'message' => trans('label.notification.delete_success')
            ]);
        }

        return response()->json([
            'status' => 'error',
            'title' => trans('label.error'),
            'message' => trans('label.something_went_wrong')
        ]);
    }

    public function changeSorting(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required|integer',
            'sorting' => 'integer|min:0|nullable',
        ]);
        try {
            $modelId = $request->post('item_id');
            $sorting = $request->post('sorting');

            $model = $this->model->findOrFail($modelId);
            $model->sorting = $sorting;
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
}
