<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class AnalysisController extends Controller
{
    /**
     * 分析初期画面
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Analysis');
    }
}
