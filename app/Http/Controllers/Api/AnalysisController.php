<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnalysisController extends Controller
{
    /**
     * データ分析処理（API）
     *
     * @param Request $request
     * @param Order   $order
     * @return JsonResponse
     */
    public function __invoke(Request $request, Order $order): JsonResponse
    {
        list($data, $labels, $totals) = $order->getParchseBetweenDate($request);

        return response()->json([
            'data'   => $data,
            'labels' => $labels,
            'totals' => $totals,
            'type'   => $request->type
        ], Response::HTTP_OK);
    }
}
