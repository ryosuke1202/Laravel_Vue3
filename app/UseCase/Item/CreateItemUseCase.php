<?php

namespace App\UseCase\Item;

use App\Http\Requests\StoreItemRequest;
use App\Models\Item;
use App\Repositories\ItemQuery;

class CreateItemUseCase
{
    /**
     * 初期化する
     *
     * @param ItemQuery $itemQuery ItemQueryインスタンス
     */
    public function __construct(ItemQuery $itemQuery)
    {
        $this->itemQuery = $itemQuery;
    }

    /**
     * 商品登録処理
     *
     * @param StoreItemRequest $request
     * @return Item
     */
    public function invoke(StoreItemRequest $request): Item
    {
        return $this->itemQuery->itemCreate($request);
    }
}
