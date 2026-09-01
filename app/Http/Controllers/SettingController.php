<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function publicPin()
    {
        $pinEnabled = (string) Setting::get('public_pin_enabled', '0') === '1';
        $previewPinEnabled = (string) Setting::get('public_preview_pin_enabled', '0') === '1';
        $pin = Setting::get('public_pin', '123456');

        return view('settings.public_pin', compact('pinEnabled', 'previewPinEnabled', 'pin'));
    }

    public function updatePublicPin(Request $request)
    {
        $request->validate([
            'public_pin' => 'required|string|min:4|max:10',
        ], [
            'public_pin.required' => 'PIN tidak boleh kosong.',
            'public_pin.min' => 'PIN minimal terdiri dari 4 karakter/angka.',
            'public_pin.max' => 'PIN maksimal terdiri dari 10 karakter/angka.',
        ]);

        $isEnabled = $request->has('public_pin_enabled') ? '1' : '0';
        $isPreviewEnabled = $request->has('public_preview_pin_enabled') ? '1' : '0';

        Setting::set('public_pin_enabled', $isEnabled);
        Setting::set('public_preview_pin_enabled', $isPreviewEnabled);
        Setting::set('public_pin', $request->public_pin);

        return back()->with('success', 'Pengaturan PIN Halaman Publik berhasil diperbarui.');
    }
}
