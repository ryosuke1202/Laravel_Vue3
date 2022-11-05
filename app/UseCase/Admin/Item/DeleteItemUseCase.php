<?php

namespace App\UseCase\Admin\Item;

use App\Http\Requests\UpdateItemRequest;
use App\Repositories\ItemQuery;

class DeleteItemUseCase
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
     * @param UpdateItemRequest $request
     * @return bool
     */
    public function invoke(int $id): bool
    {
        return $this->itemQuery->itemDelete($id);
    }
}
