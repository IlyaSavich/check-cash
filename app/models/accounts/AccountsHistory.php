<?php

namespace App\Models\accounts;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountsHistory
 * @package App\Models\accounts
 *
 * @property int $id
 * @property double $money
 * @property string $created_at
 * @property string $description
 * @property int $currency_id
 * @property string $currency
 * @property string $account_id
 */
class AccountsHistory extends \Eloquent
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

    /**
     * Transaction belongs to account
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('App\Models\accounts\Account');
    }

    /**
     * Transaction currency
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    public function setUpdatedAt($value)
    {
    }
}
