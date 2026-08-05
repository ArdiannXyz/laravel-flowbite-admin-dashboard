<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockOpname extends Model
{
    use HasFactory;

    protected $fillable = [
        'opname_code',
        'product_id',
        'user_id',
        'system_stock',
        'physical_stock',
        'difference',
        'opname_date',
        'notes',
    ];

    protected $casts = [
        'opname_date' => 'date',
        'system_stock' => 'integer',
        'physical_stock' => 'integer',
        'difference' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
