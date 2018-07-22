<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Request success common function
     *
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = [], $message = 'success！')
    {
        return response()->json([
            'code' => 200,
            'status' => true,
            'data' => $data,
            'message' => $message
        ]);
    }

    /**
     * Request fail common function
     *
     * @param int $code
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function fail($message = 'fail！', $code = 400, $data = [])
    {
        return response()->json([
            'code' => $code,
            'status' => false,
            'data' => $data,
            'message' => $message
        ]);
    }
}
