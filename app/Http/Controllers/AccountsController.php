<?php

namespace App\Http\Controllers;

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
        $accounts = Account::all();

        return view('accounts.list', compact('accounts'));
    }

    /**
     * Rendering form for creating new account
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(CreateAccountRequest $request)
    {
        $account = Account::create(array_merge($request->all(), ['user_id' => \Auth::user()->id]));

        return redirect()->route('accounts.view', ['id' => $account->id]);
    }

    /**
     * View single account by id
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        $transactions = AccountsHistory::all()->where('account_id', $id);
        if (empty($transactions->getDictionary())) {
            $money = 0;
        } else {
            $money = 0;
            foreach ($transactions as $item) {
                $money += $item->money;
            }
        }

        $account = Account::findOrFail($id);

        return view('accounts.view', compact('account', 'money'));
    }

    public function transaction($id)
    {
        $account = Account::findOrFail($id);
        return view('accounts.transaction', compact('account'));
    }
}
