<?php

namespace App;

/**
 * Class Currency
 * @package App
 *
 * @property int $id
 * @property string $name
 */
class Currency extends \Eloquent
{
    protected $table = 'currency';
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function transaction()
    {
        return $this->hasMany('App\Models\accounts\AccountsHistory');
    }
}
