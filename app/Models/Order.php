<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $primaryKey = 'order_number';
    protected $fillable = [
        'customer_fullname',
        'created_at',
        'status',
        'comment'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
