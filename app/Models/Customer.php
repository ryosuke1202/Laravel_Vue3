<?php

namespace App\Models;

use App\Builder\CustomerBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kana',
        'tel',
        'email',
        'postcode',
        'address',
        'birthday',
        'gender',
        'emmemoail'
    ];

    /**
     * Begin querying the model
     *
     * @return CustomerBuilder
     */
    public static function query(): CustomerBuilder
    {
        return parent::query();
    }

    /**
     * Create a new Eloquent CustomerBuilder for the model.
     *
     * @param  Builder  $query
     * @return CustomerBuilder
     */
    public function newEloquentBuilder($query): CustomerBuilder
    {
        return new CustomerBuilder($query);
    }

    /**
     * purchasesテーブルへのリレーション（1対多）
     *
     * @return HasMany
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * 顧客一覧表示（検索込み）
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getCustomerList(Request $request): LengthAwarePaginator
    {
        return Customer::query()
            ->searchCustomers($request->search)
            ->paginate(50);
    }
}
