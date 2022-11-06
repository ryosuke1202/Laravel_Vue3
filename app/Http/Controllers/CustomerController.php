<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\UseCase\Customer\CreateCustomerUseCase;
use App\UseCase\Customer\GetCustomerListUseCase;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * 顧客一覧表示画面
     *
     * @param Request $request
     * @param GetCustomerListUseCase $userCase
     * @return \Inertia\Response
     */
    public function index(Request $request, GetCustomerListUseCase $useCase): Response
    {
        $customers = $useCase->invoke($request);

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
     * @param  CreateCustomerUseCase $request
     * @return RedirectResponse
     */
    public function store(StoreCustomerRequest $request, CreateCustomerUseCase $useCase): RedirectResponse
    {
        $useCase->invoke($request);

        return to_route('customers.index')->with([
            'message' => '登録しました',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
