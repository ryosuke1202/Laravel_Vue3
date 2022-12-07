<?php

namespace App\Builder;

use Illuminate\Database\Eloquent\Builder;

class CustomerBuilder extends Builder
{
    /**
     * 顧客検索
     *
     * @param string|null $input
     * @return static
     */
    public function searchCustomers(?string $input): static
    {
        return $this->where('kana', 'like', $input)
                    ->orWhere('tel', 'like', $input);
    }
    
}