<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;
use Inertia\Response;

class AnalysisController extends Controller
{
    /**
     * 分析初期画面
     *
     * @param Order $order
     * @return Response
     */
    public function index(Order $order): Response
    {
        return Inertia::render('Analysis');
    }
}
