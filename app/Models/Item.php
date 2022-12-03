<?php

namespace App\Models;

use App\Builder\ItemBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'memo',
        'price',
        'is_selling',
    ];

    /**
     * Begin querying the model
     *
     * @return ItemBuilder
     */
    public static function query(): ItemBuilder
    {
        return parent::query();
    }

    /**
     * Create a new Eloquent CustomerBuilder for the model.
     *
     * @param  Builder  $query
     * @return ItemBuilder
     */
    public function newEloquentBuilder($query): ItemBuilder
    {
        return new ItemBuilder($query);
    }

    /**
     * purchasesテーブルとのリレーション（多対多）
     *
     * @return BelongsToMany
     */
    public function purchase(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class)->withPivot('quantity');
    }

    /**
     * 販売中の商品情報を取得
     *
     * @return Collection
     */
    public function getSellingItems(): Collection
    {
        return $this->query()
            ->sellingItem()
            ->get();
    }

    /**
     * Undocumented function
     *
     * @param Purchase $purchase
     * @return array
     */
    public function aaa(Purchase $purchase): array
    {
        $allItems = Item::all();

        $items = [];

        foreach ($allItems as $allItem) {
            $quantity = 0;
            foreach ($purchase->items as $item) {
                if ($allItem->id === $item->id) {
                    $quantity = $item->pivot->quantity;
                }
            }
            $items[] = [
                'id' => $allItem->id,
                'name' => $allItem->name,
                'price' => $allItem->price,
                'quantity' => $quantity,
            ];
        }

        return $items;
    }
}
