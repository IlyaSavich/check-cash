<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
