<?php

namespace App\Http\Controllers;

use App\Helpers\AccountsHistoryHelper;
use App\Http\Requests\CreateTransactionRequest;
use App\Models\accounts\Account;
use App\Models\accounts\AccountsHistory;
use Illuminate\Http\Request;

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
        $account = Account::findOrFail($id);

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
        AccountsHistory::create(AccountsHistoryHelper::checkTransactionType($request->all()));

        return redirect()->route('accounts.view', ['id' => $request->all()['account_id']]);
    }
}