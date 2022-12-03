<?php

namespace App\Http\Controllers;

use App\Models\InertiaTest as ModelsInertiaTest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class InertiaTestController extends Controller
{
    public function index()
    {
        $blogs = ModelsInertiaTest::all();
        return Inertia::render('Inertia/Index', ['blogs' => $blogs]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Inertia/Create');
    }

    public function show($id)
    {
        $blog = ModelsInertiaTest::findOrfail($id);
        return Inertia::render('Inertia/Show', [
            'id' => $id,
            'blog' => $blog,
        ]);
    }
    public function store(Request $request, ModelsInertiaTest $inertiaTest)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'max:20'],
            'content' => ['required'],
        ]);

        $inertiaTest->create($request->all());

        return to_route('inertia.index')->with(['message' => '登録しました']);
    }
    public function delete(int $id)
    {
        $blog = ModelsInertiaTest::findOrfail($id);
        $blog->delete();

        return to_route('inertia.index')->with('message', '削除しました');
    }
}
