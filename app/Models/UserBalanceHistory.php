<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBalanceHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'userBalanceId',
        'balanceBefore',
        'balanceAfter',
        'activity',
        'type',
        'ip',
        'location',
        'userAgent',
        'author',
    ];

    protected $table = 'user_balance_history';
}
