<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'status'
    ];

    /**
     * customerテーブルとのリレーション（1対多（逆））
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * itemsテーブルとのリレーション（多対多）
     *
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity');
    }

    /**
     * 購入処理
     *
     * @param array $request
     * @return Purchase
     */
    public function createPurchase(array $request): Purchase
    {
        $insertData = [
            'customer_id' => $request['customer_id'],
            'status'      => $request['status']
        ];

        $purchase = Purchase::create($insertData);

        return $purchase;
    }

    /**
     * 中間テーブルへの登録
     *
     * @param array    $items
     * @param Purchase $purchase
     * @return void
     */
    public function attachItemPurchase(array $items, Purchase $purchase): void
    {
        foreach ($items as $item) {
            $purchase->items()->attach($purchase->id, [
                'item_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);
        }
    }

    /**
     * ステータスの更新
     *
     * @param Purchase $purchase
     * @param integer $status
     * @return void
     */
    public function updateStatus(Purchase $purchase, int $status): void
    {
        $purchase->status = $status;
        $purchase->save();
    }

    /**
     * 中間テーブルの更新
     *
     * @param array $items
     * @param Purchase $purchase
     * @return void
     */
    public function syncItemPurchase(array $itemArray, Purchase $purchase): void
    {
        $items = [];

        foreach ($itemArray as $item) {
            $items = $items + [
                $item['id'] => [
                    'quantity' => $item['quantity']
                ]
            ];
        }

        $purchase->items()->sync($items);
    }
}
