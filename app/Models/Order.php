<?php

namespace App\Models;

use App\Builder\OrderBuilder;
use App\Models\Scopes\Subtotal;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
     * @param OrderBuilder $subQuery
     * @param string       $date 日付形式
     * @return array
     */
    public function getParchseBetweenDate(OrderBuilder $subQuery, string $date): array
    {
        $subQuery->where('status', true)
            ->groupBy('id')
            ->selectRaw('SUM(subtotal) as totalPerPurchase, DATE_FORMAT(created_at, ?) as date', [$date])
            ->groupBy('date');

        $data = DB::table($subQuery)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();

        $labels = $data->pluck('date');
        $totals = $data->pluck('total');


        return [$data, $labels, $totals];
    }

    /**
     * デシル分析
     *
     * @param OrderBuilder $subQuery
     * @return array
     */
    public function getDecile(OrderBuilder $subQuery): array
    {
        // 1. 購買ID毎にまとめる
        $subQuery = $subQuery
            ->groupBy('id')
            ->selectRaw('id, customer_id, customer_name, SUM(subtotal) as totalPerPurchase');

        // 2. 会員毎にまとめて購入金額順にソートする 
        $subQuery = DB::table($subQuery)
            ->groupBy('customer_id')
            ->selectRaw('customer_id, customer_name, sum(totalPerPurchase) as total')
            ->orderBy('total', 'desc');

        // statementで変数を設定できる
        // set @変数名 = 値 (mysqlの書き方) // 3. 購入順に連番を振る
        DB::statement('set @row_num = 0;');
        $subQuery = DB::table($subQuery)
            ->selectRaw('
                @row_num:= @row_num+1 as row_num,
                customer_id,
                customer_name,
                total'
            );

        // 4. 全体の件数を数え、1/10の値や合計金額を取得
        $count = DB::table($subQuery)->count();
        $total = DB::table($subQuery)->selectRaw('sum(total) as total')->get();
        $total = $total[0]->total; // 構成比用
        $decile = ceil($count / 10); // 10分の1の件数を変数に入れる
        $bindValues = [];
        $tempValue = 0;
        for($i = 1; $i <= 10; $i++) {
            array_push($bindValues, 1 + $tempValue);
            $tempValue += $decile;
            array_push($bindValues, 1 + $tempValue);
        }

        // 5 10分割しグループ毎に数字を振る 
        DB::statement('set @row_num = 0;');
        $subQuery = DB::table($subQuery)
            ->selectRaw("
                row_num,
                customer_id,
                customer_name,
                total,
                case
                    when ? <= row_num and row_num < ? then 1
                    when ? <= row_num and row_num < ? then 2
                    when ? <= row_num and row_num < ? then 3
                    when ? <= row_num and row_num < ? then 4
                    when ? <= row_num and row_num < ? then 5
                    when ? <= row_num and row_num < ? then 6
                    when ? <= row_num and row_num < ? then 7
                    when ? <= row_num and row_num < ? then 8
                    when ? <= row_num and row_num < ? then 9
                    when ? <= row_num and row_num < ? then 10
                end as decile",
                $bindValues
            ); // SelectRaw第二引数にバインドしたい数値(配列)をいれる

            // round, avg はmysqlの関数 
            // 6. グループ毎の合計・平均
            $subQuery = DB::table($subQuery)
                ->groupBy('decile')
                ->selectRaw('
                    decile,
                    round(avg(total)) as average,
                    sum(total) as totalPerGroup
                ');

            // 7 構成比
            DB::statement("set @total = ${total} ;");
            $data = DB::table($subQuery)
                ->selectRaw('
                    decile,
                    average,
                    totalPerGroup,
                    round(100 * totalPerGroup / @total, 1) as totalRatio
                ')
                ->get();

            $labels = $data->pluck('dadecilete');
            $totals = $data->pluck('totalPerGroup');
    
    
            return [$data, $labels, $totals];
    }
}
