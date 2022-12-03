<?php

namespace App\Builder;

use Illuminate\Database\Eloquent\Builder;

class OrderBuilder extends Builder
{
    /**
     * 期間指定のスコープ
     *
     * @param string|null $startDate
     * @param string|null $endDate
     * @return static
     */
    public function betweenDate(?string $startDate = null, ?string $endDate = null): static
    {
        if (is_null($startDate) && is_null($endDate)) {
            return $this;
        }

        if (!is_null($startDate) && is_null($endDate)) {
            return $this->whereDate('created_at', ">=", $startDate);
        }

        if (is_null($startDate) && !is_null($endDate)) {
            return $this->whereDate('created_at', '<=', $endDate);
        }
        
        if (!is_null($startDate) && !is_null($endDate)) {
            return $this->whereDate('created_at', ">=", $startDate)
                         ->whereDate('created_at', '<=', $endDate);
        }
    }
}
