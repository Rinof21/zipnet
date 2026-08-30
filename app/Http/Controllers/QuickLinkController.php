<?php

namespace App\Http\Controllers;

use App\Models\QuickLink;
use Illuminate\Http\Request;

class QuickLinkController extends Controller
{
    public function index()
    {
        $quickLinks = QuickLink::orderBy('sort_order', 'asc')->get();
        return view('quick_links.index', compact('quickLinks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'sort_order' => 'nullable|integer',
        ], [
            'title.required' => 'Judul link wajib diisi.',
            'url.required' => 'URL link wajib diisi.',
            'url.url' => 'Format URL tidak valid (harus diawali http:// atau https://).',
        ]);

        QuickLink::create([
            'title' => $request->title,
            'url' => $request->url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        return redirect()->route('quick-links.index')->with('success', 'Link berhasil ditambahkan.');
    }

    public function update(Request $request, QuickLink $quickLink)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'sort_order' => 'nullable|integer',
        ], [
            'title.required' => 'Judul link wajib diisi.',
            'url.required' => 'URL link wajib diisi.',
            'url.url' => 'Format URL tidak valid (harus diawali http:// atau https://).',
        ]);

        $quickLink->update([
            'title' => $request->title,
            'url' => $request->url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : false,
        ]);

        return redirect()->route('quick-links.index')->with('success', 'Link berhasil diperbarui.');
    }

    public function destroy(QuickLink $quickLink)
    {
        $quickLink->delete();
        return redirect()->route('quick-links.index')->with('success', 'Link berhasil dihapus.');
    }
}
