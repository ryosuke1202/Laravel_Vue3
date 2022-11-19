<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Purchase;
use App\UseCase\Purchase\ShowPurchaseFormUseCase;
use Inertia\Inertia;
use Inertia\Response;

class PurchaseController extends Controller
{
    /**
     * item instance.
     *
     * @var Item
     */
    protected $item;

    /**
     * item instance.
     *
     * @var Customer
     */
    protected $customer;


    /**
     * 初期化
     *
     * @param  Item      $item
     * @param  Customer  $customer
     * @return void
     */
    public function __construct(Item $item, Customer $customer)
    {
        $this->item = $item;
        $this->customer = $customer;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * 購入画面表示
     *
     * @return Response
     */
    public function create(): Response
    {
        //顧客情報取得
        $customers = $this->customer->all();

        //販売中の商品を取得
        $items = $this->item->getSellingItems();

        return Inertia::render('Purchases/Create', [
            'customers' => $customers,
            'items'     => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
