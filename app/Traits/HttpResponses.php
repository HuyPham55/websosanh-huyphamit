<?php

namespace App\Traits;

trait HttpResponses
{
    protected function success($data, $message = null, $status = 200)
    {
        if ($message === null) {
            $message = trans('label.notification.success');
        }
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
    }

    protected function error($data, $message = null, $status = null)
    {
        return response()->json([
            'status' => 'danger',
            'message' => $message,
            'data' => $data
        ], $status);
    }

}
