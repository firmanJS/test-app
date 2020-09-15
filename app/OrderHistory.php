<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = [
        'code_histories', 'inventory_id', 'qty', 'status', 'total'
    ];
}
