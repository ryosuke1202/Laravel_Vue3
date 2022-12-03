<?php

namespace App\Builder;

use Illuminate\Database\Eloquent\Builder;

class ItemBuilder extends Builder
{
    /**
     * 販売中の商品情報を取得
     *
     * @return static
     */
    public function sellingItem(): static
    {
        return $this->where('is_selling', true);
    }
}
