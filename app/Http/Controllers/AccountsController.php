<?php

namespace App\Http\Controllers;

use App\Helpers\AccountContainer;
use App\Helpers\AccountsHistoryContainer;
use App\Helpers\GraphHelper;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\SetIntervalRequest;
use App\Models\accounts\Account;
use Illuminate\Http\Request;

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

    /**
     * View all accounts
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $accounts = AccountContainer::getAllAccounts();

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
        $account = AccountContainer::storeNewAccount($request);

        return redirect()->route('accounts.view', ['id' => $account->id]);
    }

    /**
     * View single account
     *
     * @param $id int Account id
     * @param SetIntervalRequest|Request $request
     * @param GraphHelper $graphHelper
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id, SetIntervalRequest $request, GraphHelper $graphHelper)
    {
        /** @var $account Account */
        $account = AccountContainer::getAccountWithBalance($id);
        $chartData = $graphHelper->getGraphData($id, $request);
        $history = AccountsHistoryContainer::getHistory($id);

        return view('accounts.view', compact('account', 'chartData', 'history'));
    }

    /**
     * View form for editing the account
     * @param $id int Account id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $account = AccountContainer::getAccount($id);

        return view('accounts.edit', compact('account'));
    }

    /**
     * Update the account and view it
     *
     * @param $id int
     * @param CreateAccountRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, CreateAccountRequest $request)
    {
        AccountContainer::updateAccount($id, $request);

        return redirect()->route('accounts.view', ['id' => $id]);
    }
}
