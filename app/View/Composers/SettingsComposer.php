<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SettingsComposer
{
    public function compose(View $view): void
    {
        $view->with('settings', [
            'app_name'     => Setting::get('app_name', 'Stockify Inventory'),
            'app_logo'     => Setting::get('app_logo', null),
            'company_name' => Setting::get('company_name', 'PT Stockify Utama Indonesia'),
        ]);
    }
}