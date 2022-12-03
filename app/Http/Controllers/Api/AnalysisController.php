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
        $subQuery = Order::query()->betweenDate($request->startDate, $request->endDate);

        if ($request->type === 'perDay') {
            $day = '%Y%m%d';
            list($data, $labels, $totals) = $order->getParchseBetweenDate($subQuery, $day);
        }

        if ($request->type === 'perMonth') {
            $month = '%Y%m';
            list($data, $labels, $totals) = $order->getParchseBetweenDate($subQuery, $month);
        }

        if ($request->type === 'perYear') {
            $year = '%Y';
            list($data, $labels, $totals) = $order->getParchseBetweenDate($subQuery, $year);
        }

        if ($request->type === 'decile') {
            list($data, $labels, $totals) = $order->getDecile($subQuery);
        }

        return response()->json([
            'data'   => $data,
            'labels' => $labels,
            'totals' => $totals,
            'type'   => $request->type
        ], Response::HTTP_OK);
    }
}
