<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
     * purchase instance.
     *
     * @var Purchase
     */
    protected $purchase;


    /**
     * 初期化
     *
     * @param  Item      $item
     * @param  Customer  $customer
     * @param  Purchase  $purchase
     * @return void
     */
    public function __construct(Item $item, Customer $customer, Purchase $purchase)
    {
        $this->item = $item;
        $this->customer = $customer;
        $this->purchase = $purchase;
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
        //販売中の商品を取得
        $items = $this->item->getSellingItems();

        return Inertia::render('Purchases/Create', [ 'items' => $items]);
    }

    /**
     * 購入処理（中間テーブルへの登録含む）
     *
     * @param  StorePurchaseRequest  $request
     * @return RedirectResponse
     */
    public function store(StorePurchaseRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $purchase = $this->purchase->createPurchase($request->all());
    
            $this->purchase->attachItemPurchase($request->items, $purchase);
        });

        return to_route('dashboard');
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
