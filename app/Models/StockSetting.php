<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_min_stock',
        'auto_notify_low_stock',
        'notification_email',
    ];
}
