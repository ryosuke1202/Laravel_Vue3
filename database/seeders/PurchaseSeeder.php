<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * purchasesテーブルへの登録と中間テーブルへの登録を同時にやっている
     *
     * @return void
     */
    public function run()
    {
        $items = Item::all();
        Purchase::factory(100)->create()->each(function(Purchase $purchase) use ($items) {
            $purchase->items()->attach(
                $items->random(rand(1,3))->pluck('id')->toArray(), // 1~3個のitemをpurchaseにランダムに紐づけ 
                ['quantity' => rand(1, 5)]
            );
        });
    }
}
