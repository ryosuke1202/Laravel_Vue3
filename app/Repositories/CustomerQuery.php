<?php

namespace App\Repositories;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as FacadesDB;

class CustomerQuery
{
    /**
     * 初期化する
     * 
     * @param Customer $customer Customerインスタンス
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * 顧客一覧表示（検索込み）
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCustomers(Request $request): LengthAwarePaginator
    {
        // dd(FacadesDB::table('items')->insert(['name' => '名前', 'price' => 123]));
        // dd(Customer::query()->where('id', 1)->get());
        // Customer::query()->where('id', 1)->get();
        return $this->customer->query()
            ->searchCustomers($request->search)
            ->select('id', 'name', 'kana', 'tel')
            ->paginate(50);
    }

    /**
     * 顧客新規作成処理
     *
     * @param StoreCustomerRequest $request
     * @return Customer
     */
    public function customerCreate(StoreCustomerRequest $request): Customer
    {
        return $this->customer->create($request->all());
    }
}