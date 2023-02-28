<?php

namespace App\Http\Controllers\Backend;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeSlideController extends BaseController
{
    //
    const CACHE_NAME = '';
    private string $pathView;
    private string $routeList;
    private Slide $model;
    private string $key;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Slide();
        $this->key = 'HOME';
        $this->routeList = 'home_slides.list';
        $this->pathView = 'admin.home_slides';
    }

    public function index()
    {
        session(['url.intended' => url()->full()]);
        $data = $this->model::where('key', $this->key)
            ->orderBy('sorting')
            ->orderBy('id')
            ->paginate();

        return view("{$this->pathView}.list", compact('data'));
    }

    public function getAdd()
    {
        return view("{$this->pathView}.add", ['slide' => $this->model]);
    }

    public function postAdd(Request $request)
    {
        $flag = $this->model::saveModel($this->model, $this->key, $request);
        if ($flag) {
            $this->forgetCache();
            return redirect()->route($this->routeList)->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
        }
        return redirect()->back()->with([
            'status' => 'danger',
            'flash_message' => trans('label.something_went_wrong')
        ]);
    }

    public function getEdit(int $id)
    {
        $slide = $this->model::findOrFail($id);

        return view("{$this->pathView}.edit", compact('slide'));
    }

    public function putEdit(Request $request, int $id)
    {
        $model = $this->model::findOrFail($id);
        $flag = $this->model::saveModel($model, $this->key, $request);
        if ($flag) {
            $this->forgetCache();
            return redirect()->intended(route($this->routeList))->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
        }
        return redirect()->back()->with([
            'status' => 'danger',
            'flash_message' => trans('label.something_went_wrong')
        ]);
    }

    public function delete(Request $request)
    {
        $model = $this->model::findOrFail($request->post('item_id'));
        $flag = $model->delete();
        if ($flag) {
            $this->forgetCache();
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
            $this->forgetCache();
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

    protected function forgetCache()
    {
        Cache::forget(self::CACHE_NAME);
    }
}
