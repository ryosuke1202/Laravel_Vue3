<?php

namespace App\Http\Controllers;

use App\Models\InertiaTest as ModelsInertiaTest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class InertiaTestController extends Controller
{
    public function index()
    {
        return Inertia::render('Inertia/Index');
    }

    public function create(Request $request)
    {
        return Inertia::render('Inertia/Create');
    }

    public function show($id)
    {
        return Inertia::render('Inertia/Show', [
            'id' => $id
        ]);
    }
    public function store(Request $request, ModelsInertiaTest $inertiaTest)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'title' => ['required', 'max:20'],
            'content' => ['required'],
        ]);

        $inertiaTest->create($request->all());

        return to_route('inertia.index');
    }
}
