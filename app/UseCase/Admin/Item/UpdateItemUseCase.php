<?php

namespace App\UseCase\Admin\Item;

use App\Http\Requests\UpdateItemRequest;
use App\Repositories\ItemQuery;

class UpdateItemUseCase
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
     * 商品削除処理
     *
     * @param UpdateItemRequest $request
     * @return bool
     */
    public function invoke(UpdateItemRequest $request): bool
    {
        return $this->itemQuery->itemUpdate($request);
    }
}
