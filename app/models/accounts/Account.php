<?php
namespace App\Models\accounts;

/**
 * Class Account
 * @package App\Models\accounts
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $user_id
 * @property int $balance
 * @property int $currentMonthIncome
 */
class Account extends \Eloquent
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    /**
     * An account is belongs to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Transactions that carried out over the account
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaction()
    {
        return $this->hasMany('App\Models\accounts\AccountsHistory');
    }
}
