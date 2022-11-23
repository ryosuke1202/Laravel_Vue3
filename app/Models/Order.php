<?php

namespace App\Models;

use App\Models\Scopes\Subtotal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new Subtotal);
    }

    /**
     * 購買履歴一覧取得
     *
     * @return LengthAwarePaginator
     */
    public function getParchseList(): LengthAwarePaginator
    {
        $order = Order::query()
            ->groupBy('id')
            ->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at' )
            ->paginate(50);
        
        return $order;
    }
    
   /**
    * 購買履歴詳細を取得
    *
    * @param integer $id
    * @return Order
    */
    public function getParchseDetail(int $id): Order
    {
        $order = Order::query()
            ->where('id', $id)
            ->groupBy('id')
            ->selectRaw('id, customer_name, customer_id, sum(subtotal) as total, status, created_at' )
            ->first();
        
        return $order;
    }
}
