<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class SearchCustomer extends Controller
{
    
    /**
     * 顧客検索機能
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function __invoke(Request $request, Customer $customer): LengthAwarePaginator
    {
        return $customer->getCustomerList($request->search);
    }
}
