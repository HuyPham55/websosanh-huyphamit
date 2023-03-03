<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\MemberAddRequest;
use App\Http\Requests\MemberEditRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MemberController extends BaseController
{
    //

    private Member $model;
    private string $routeList;
    private string $pathView;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Member();
        $this->pathView = 'admin.members';
        $this->routeList = 'members.list';
        $genders = [
            '1' => __("label.gender.male"),
            '0' => __("label.gender.female"),
        ];
        View::share([
            'genders' => $genders
        ]);

    }

    public function index(Request $request)
    {
        $data = $this->model
            ->filter($request->all())
            ->orderby('created_at', 'DESC')
            ->orderBy('id')
            ->paginate();
        return view("{$this->pathView}.list", compact('data'));
    }

    public function getAdd()
    {
        $member = $this->model;
        return view("{$this->pathView}.add", compact('member'));
    }

    public function postAdd(MemberAddRequest $request)
    {
        $flag = $this->model->saveModel($this->model, $request);
        if (!$flag instanceof \Exception) {
            return redirect()->route($this->routeList)->with(['status' => 'success', 'flash_message' => trans('label.notification.success')]);
        }
        return redirect()->back()->with([
            'status' => 'danger',
            'flash_message' => trans('label.something_went_wrong')
        ]);
    }

    public function getEdit($id)
    {
        $member = $this->model->findOrFail($id);
        return view("{$this->pathView}.edit", compact('member'));
    }

    public function putEdit($id, MemberEditRequest $request)
    {
        $model = $this->model->findOrFail($id);
        $flag = $this->model::saveModel($model, $request);

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
        $member = $this->model::findOrFail($request->item_id);
        $flag = $member->delete();
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
}
