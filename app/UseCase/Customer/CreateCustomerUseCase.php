<?php

namespace App\UseCase\Customer;

use App\Models\Customer;
use App\Repositories\CustomerQuery;
use Illuminate\Http\Request;

class CreateCustomerUseCase
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
     * 顧客登録処理
     *
     * @param Request $request
     * @return Customer
     */
    public function invoke(Request $request): Customer
    {
        return $this->customerQuery->customerCreate($request);
    }
}
