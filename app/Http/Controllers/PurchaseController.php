<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
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
     * purchase instance.
     *
     * @var Purchase
     */
    protected $purchase;

    /**
     * order instance.
     *
     * @var Order
     */
    protected $order;


    /**
     * 初期化
     *
     * @param  Item      $item
     * @param  Purchase  $purchase
     * @return void
     */
    public function __construct(
        Item $item,
        Order $order,
        Purchase $purchase
    )
    {
        $this->item     = $item;
        $this->order    = $order;
        $this->purchase = $purchase;
    }
    
    /**
     * 購入履歴画面表示
     *
     * @return Response
     */
    public function index(): Response
    {
        $orders = $this->order->getParchseList();

        return Inertia::render('Purchases/Index', ['orders' => $orders]);
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

        return Inertia::render('Purchases/Create', ['items' => $items]);
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
     * @param  Purchase  $purchase
     * @return Response
     */
    public function show(Purchase $purchase, Order $order): Response
    {
        // 小計
        $items = $order->where('id', $purchase->id)->get();
        // 合計
        $order = $order->getParchseDetail($purchase->id);

        return Inertia::render('Purchases/Show', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * 更新画面表示
     *
     * @param Purchase  $purchase
     * @return Response
     */
    public function edit(Purchase $purchase): Response
    {
        $items = $this->item->aaa($purchase);
        
        $order = $this->order->getParchseDetail($purchase->id);

        return Inertia::render('Purchases/Edit', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * 更新処理
     *
     * @param  UpdatePurchaseRequest  $request
     * @param  Purchase               $purchase
     * @return RedirectResponse
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase): RedirectResponse
    {
        DB::transaction(function () use ($purchase, $request) {
            // ステータスの更新
            $purchase->updateStatus($purchase, $request->status);

            // 中間テーブルの更新
            $purchase->syncItemPurchase($request->items, $purchase);
        });

        return to_route('dashboard');
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
