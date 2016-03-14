<?php

namespace App\Http\Controllers;

use App\Helpers\AccountHelper;
use App\Helpers\AccountsHistoryHelper;
use App\Helpers\DateHelper;
use App\Http\Requests;
use App\Http\Requests\CreateAccountRequest;
use App\Models\accounts\Account;
use App\Models\accounts\AccountsHistory;

class AccountsController extends Controller
{
    /**
     * User need to authenticate to work with their accounts
     * AccountsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $accounts = AccountHelper::mergeAccountWithMoney(Account::all());

        return view('accounts.list', compact('accounts'));
    }

    /**
     * View form for creating new account
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Save a new account
     * @param CreateAccountRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateAccountRequest $request)
    {
        $account = Account::create(array_merge($request->all(), ['user_id' => \Auth::user()->id]));

        return redirect()->route('accounts.view', ['id' => $account->id]);
    }

    /**
     * View single account
     * @param $id int Account id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        $account = Account::findOrFail($id);
        $account->balance = AccountsHistory::where('account_id', $id)->sum('money');

        $chartData = AccountsHistoryHelper::getGraphData($id);
        $chartData = json_encode($chartData);

        return view('accounts.view', compact('account', 'chartData'));
    }

    /**
     * View form for editing the account
     * @param $id int Account id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $account = Account::findOrFail($id);

        return view('accounts.edit', compact('account'));
    }

    /**
     * Update the account and view it
     * @param CreateAccountRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateAccountRequest $request)
    {
        $account = Account::create(array_merge($request->all(), ['user_id' => \Auth::user()->id]));

        return redirect()->route('accounts.view', ['id' => $account->id]);
    }
}
