<?php

namespace App\Models\accounts;

use Illuminate\Database\Eloquent\Model;

class AccountsHistory extends Model
{
    protected $table = 'accounts_history';
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'account_id',
        'money',
        'description',
        'currency_id',
    ];
}
