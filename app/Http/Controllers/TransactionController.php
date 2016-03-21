<?php

namespace App\Http\Controllers;

use App\Helpers\AccountContainer;
use App\Helpers\AccountsHistoryContainer;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * User need to authenticate to make transaction
     * AccountsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * View form for new transaction
     * @param $id integer account id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id)
    {
        $account = AccountContainer::getAccount($id);

        return view('accounts.transaction', compact('account'));
    }

    /**
     * Store transaction in database
     * @param CreateTransactionRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(CreateTransactionRequest $request)
    {
        $transaction = AccountsHistoryContainer::storeNewTransaction($request);

        return redirect()->route('accounts.view', ['id' => $transaction->account_id]);
    }
}