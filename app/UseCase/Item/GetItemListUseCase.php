<?php

namespace App\UseCase\Item;

use App\Repositories\ItemQuery;
use Illuminate\Database\Eloquent\Collection;

class GetItemListUseCase
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
     * 商品一覧を取得
     *
     * @return Collection
     */
    public function invoke(): Collection
    {
        return $this->itemQuery->getItems();
    }
}
