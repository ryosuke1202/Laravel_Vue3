<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\UseCase\Admin\Item\CreateItemUseCase;
use App\UseCase\Admin\Item\DeleteItemUseCase;
use App\UseCase\Admin\Item\GetItemListUseCase;
use App\UseCase\Admin\Item\UpdateItemUseCase;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ItemController extends Controller
{
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * 商品一覧表示画面
     *
     * @return Response
     */
    public function index(GetItemListUseCase $useCase): Response
    {
        $items = $useCase->invoke();

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
    public function store(StoreItemRequest $request, CreateItemUseCase $useCase): RedirectResponse
    {
        $useCase->invoke($request);

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
     * @return \Response
     */
    public function edit(Item $item): Response
    {
        return Inertia::render('Items/Edit', ['item' => $item]);
    }

    /**
     * 商品更新処理
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, UpdateItemUseCase $useCase)
    {
        $useCase->invoke($request);

        return to_route('items.index')->with([
            'message' => '更新しました',
            'status' => 'success'
        ]);
    }

    /**
     * 商品削除処理
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id, DeleteItemUseCase $useCase)
    {
        $useCase->invoke($id);

        return back()->with([
            'message' => '削除しました',
            'status' => 'danger'
        ]);
    }
}
