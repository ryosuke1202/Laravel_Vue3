<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ItemController extends Controller
{
    /**
     * 商品一覧表示画面
     *
     * @return Response
     */
    public function index(): Response
    {
        $items = Item::paginate(10);

        return Inertia::render('Items/Index', ['items' => $items]);
    }

    /**
     * 新規商品登録画面
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Items/Create');
    }

    /**
     * 新規商品登録処理
     *
     * @param StoreItemRequest $request
     * @return RedirectResponse
     */
    public function store(StoreItemRequest $request): RedirectResponse
    {
        Item::create($request->all());

        return to_route('items.index')->with([
            'message' => '登録しました',
            'status' => 'success'
        ]);
    }

    /**
     * 商品の詳細表示
     *
     * @param Item $item
     * @return Response
     */
    public function show(Item $item): Response
    {
        return Inertia::render('Items/Show', ['item' => $item]);
    }

    /**
     * 商品編集画面
     *
     * @param Item $item
     * @return Response
     */
    public function edit(Item $item): Response
    {
        return Inertia::render('Items/Edit', ['item' => $item]);
    }

    /**
     * 商品更新処理
     *
     * @param UpdateItemRequest  $request
     * @param Item               $item
     * @return RedirectResponse
     */
    public function update(UpdateItemRequest $request, Item $item): RedirectResponse
    {
        $item->update($request->all());

        return to_route('items.index')->with([
            'message' => '更新しました',
            'status' => 'success'
        ]);
    }

    /**
     * 商品削除処理
     *
     * @param Item $item
     * @return RedirectResponse
     */
    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return back()->with([
            'message' => '削除しました',
            'status' => 'danger'
        ]);
    }
}
