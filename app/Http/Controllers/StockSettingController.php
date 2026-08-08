<?php

namespace App\Http\Controllers;

use App\Models\StockSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockSettingController extends Controller
{
    public function index(): View
    {
        $setting = StockSetting::firstOrCreate([], [
            'default_min_stock' => 5,
            'auto_notify_low_stock' => true,
            'notification_email' => 'admin@stockify.test',
        ]);

        return view('pages.admin.stock-settings.index', compact('setting'));
    }

    public function update(Request $request): RedirectResponse
    {
        $setting = StockSetting::firstOrCreate([]);

        $validated = $request->validate([
            'default_min_stock' => 'required|integer|min:1',
            'auto_notify_low_stock' => 'nullable|boolean',
            'notification_email' => 'nullable|email|max:255',
        ]);

        $setting->update([
            'default_min_stock' => $validated['default_min_stock'],
            'auto_notify_low_stock' => $request->has('auto_notify_low_stock'),
            'notification_email' => $validated['notification_email'] ?? null,
        ]);

        return back()->with('success', 'Pengaturan stok minimum berhasil diperbarui.');
    }
}
