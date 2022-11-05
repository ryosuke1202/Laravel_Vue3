<?php

namespace App\Repositories;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

class ItemQuery
{
    /**
     * 初期化する
     * 
     * @param Item $item Item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * 商品一覧取得
     *
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->item->query()
            ->select('id', 'name', 'memo', 'price', 'is_selling')
            ->get();
    }

    /**
     * 商品新規作成処理
     *
     * @param StoreItemRequest $request
     * @return Item
     */
    public function itemCreate(StoreItemRequest $request): Item
    {
        return $this->item->create($request->all());
    }
    
    /**
     * 商品情報更新処理
     *
     * @param UpdateItemRequest $request
     * @return bool
     */
    public function itemUpdate(UpdateItemRequest $request): bool
    {
        return $this->item->find($request->id)->update($request->all());
    }

    /**
     * 商品削除処理
     *
     * @param int $id
     * @return bool
     */
    public function itemDelete(int $id): bool
    {
        return $this->item->find($id)->delete();
    }
}