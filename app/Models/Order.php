<?php

namespace App\Models;

use App\Builder\OrderBuilder;
use App\Models\Scopes\Subtotal;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new Subtotal);
    }

    /**
     * Begin querying the model
     *
     * @return OrderBuilder
     */
    public static function query(): OrderBuilder
    {
        return parent::query();
    }

    /**
     * Create a new Eloquent CustomerBuilder for the model.
     *
     * @param  Builder  $query
     * @return OrderBuilder
     */
    public function newEloquentBuilder($query): OrderBuilder
    {
        return new OrderBuilder($query);
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

    /**
     * 期間指定で注文情報を取得
     *
     * @param string|null $startDate
     * @param string|null $endDate
     * @return LengthAwarePaginator
     */
    // public function getParchseBetweenDateTest(?string $startDate, ?string $endDate): LengthAwarePaginator
    // {
    //     $period = Order::query()
    //         ->betweenDate($startDate, $endDate)
    //         ->selectRaw('id, sum(subtotal) as total, customer_name, status, created_at')
    //         ->orderBy('created_at')
    //         ->groupBy('id')
    //         ->paginate(50);

    //     return $period;
    // }

    /**
     * 期間指定で注文情報を取得
     *
     * @param Request $request
     * @return array
     */
    public function getParchseBetweenDate(Request $request): array
    {
        $subQuery = Order::query()->betweenDate($request->startDate, $request->endDate);
        $data = null;
        $labels = null;
        $totals = null;
        if ($request->type === 'perDay') {
            $subQuery->where('status', true)
                ->groupBy('id')
                ->selectRaw('SUM(subtotal) as totalPerPurchase, DATE_FORMAT(created_at, "%Y%m%d") as date')
                ->groupBy('date');

            $data = DB::table($subQuery)
                ->groupBy('date')
                ->selectRaw('date, sum(totalPerPurchase) as total')
                ->get();

            $labels = $data->pluck('date');
            $totals = $data->pluck('total');

        }

        return [$data, $labels, $totals];
    }
}
