<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * customer instance.
     *
     * @var Customer
     */
    protected $customer;


    /**
     * 初期化
     *
     * @param  Item  $item
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * 顧客一覧表示画面
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $customers = $this->customer->getCustomerList($request);

        return Inertia::render('Customers/Index', [
            'customers' => $customers,
        ]);
    }

    /**
     *  顧客新規登録画面
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Customers/Create');
    }

    /**
     *  顧客新規登録処理
     *
     * @param  StoreCustomerRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $this->customer->create($request->all());

        return to_route('customers.index')->with([
            'message' => '登録しました',
            'status' => 'success'
        ]);
    }
}
