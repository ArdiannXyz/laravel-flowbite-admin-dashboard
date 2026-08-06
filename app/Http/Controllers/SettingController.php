<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = [
            'app_name' => Setting::get('app_name', 'Stockify Inventory'),
            'company_name' => Setting::get('company_name', 'PT Stockify Utama Indonesia'),
            'app_logo' => Setting::get('app_logo', null),
            'contact_email' => Setting::get('contact_email', 'info@stockify.test'),
            'contact_phone' => Setting::get('contact_phone', '0812-3456-7890'),
            'address' => Setting::get('address', 'Jl. Industri Gudang Utama No. 88, Jakarta'),
        ];

        return view('pages.admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        Setting::set('app_name', $validated['app_name']);
        Setting::set('company_name', $validated['company_name']);
        Setting::set('contact_email', $validated['contact_email'] ?? '');
        Setting::set('contact_phone', $validated['contact_phone'] ?? '');
        Setting::set('address', $validated['address'] ?? '');

        if ($request->hasFile('app_logo')) {
            $oldLogo = Setting::get('app_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('app_logo')->store('settings', 'public');
            Setting::set('app_logo', $logoPath);
        }

        return back()->with('success', 'Pengaturan umum aplikasi berhasil diperbarui.');
    }
}
