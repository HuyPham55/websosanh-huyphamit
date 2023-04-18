<?php

namespace App\Traits;

trait HttpResponses
{
    protected function success(array $data, $message = null, $status = 200)
    {
        $message = $message ?: trans('label.notification.success');
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
    }

    protected function error(array $data, $message = null, int $status = 200)
    {
        $message = $message ?: trans('label.something_went_wrong');
        return response()->json([
            'status' => 'danger',
            'message' => $message,
            'data' => $data
        ], $status);
    }

}
