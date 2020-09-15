<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'item_id', 'stock', 'stock_reserved', 'stock_available'
    ];
}
