<?php

namespace App\UseCase\Admin\Customer;

use App\Repositories\CustomerQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class GetCustomerListUseCase
{
    /**
     * 初期化する
     *
     * @param CustomerQuery $customerQuery CustomerQueryインスタンス
     */
    public function __construct(CustomerQuery $customerQuery)
    {
        $this->customerQuery = $customerQuery;
    }

    /**
     * 顧客一覧を取得
     *
     * @param Request $request
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function invoke(Request $request): LengthAwarePaginator
    {
        return $this->customerQuery->getCustomers($request);
    }
}
