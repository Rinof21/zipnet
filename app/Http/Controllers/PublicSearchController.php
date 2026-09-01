<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\QuickLink;
use App\Models\Setting;
use Illuminate\Http\Request;

class PublicSearchController extends Controller
{
    public function showPinForm()
    {
        $isSearchPinEnabled = (string) Setting::get('public_pin_enabled', '0') === '1';
        $isPreviewPinEnabled = (string) Setting::get('public_preview_pin_enabled', '0') === '1';

        $isAnyPinEnabled = $isSearchPinEnabled || $isPreviewPinEnabled;

        if (!$isAnyPinEnabled || auth()->check() || session('public_pin_verified')) {
            return redirect()->route('public.search');
        }

        return redirect()->route('public.search', ['modal' => 'pin']);
    }

    public function verifyPin(Request $request)
    {
        $request->validate([
            'pin' => 'required|string',
        ], [
            'pin.required' => 'Masukkan PIN akses publik.',
        ]);

        $storedPin = Setting::get('public_pin', '123456');

        if ($request->expectsJson() || $request->ajax()) {
            if ($request->pin === $storedPin) {
                session(['public_pin_verified' => true]);
                return response()->json([
                    'success' => true,
                    'message' => 'PIN benar. Akses diberikan.'
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'PIN yang Anda masukkan salah. Silakan coba lagi.'
            ], 422);
        }

        if ($request->pin === $storedPin) {
            session(['public_pin_verified' => true]);
            $intended = session()->pull('url.intended', route('public.search'));
            return redirect($intended)->with('success', 'PIN benar. Akses diberikan.');
        }

        return back()->withErrors(['pin' => 'PIN yang Anda masukkan salah. Silakan coba lagi.'])->withInput();
    }

    public function index(Request $request)
    {
        $q = trim($request->q);

        $documents = [];

        if ($q) {
            $documents = Document::with('attachments')
                ->where(function ($query) use ($q) {
                    $query->where('title', 'like', "%$q%")
                        ->orWhere('perihal', 'like', "%$q%")
                        ->orWhere('nomor_surat', 'like', "%$q%");
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $quickLinks = QuickLink::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        return view('public.search', compact('q', 'documents', 'quickLinks'));
    }

    public function preview(Document $document, Request $request)
    {
        $user = auth()->user();
        if ($document->is_private_to_uploader) {
            if (!$user || ($document->uploaded_by !== $user->id && !$user->hasRole('Super Admin'))) {
                abort(403, 'Dokumen ini bersifat rahasia dan hanya dapat diakses oleh pengupload.');
            }
        } elseif (!$document->is_public) {
            if (!$user) {
                abort(403, 'Dokumen ini bersifat terbatas dan memerlukan login untuk diakses.');
            }
        }

        // Handle attachment stream
        if ($request->has('attachment_id')) {
            $attachment = $document->attachments()->where('id', $request->attachment_id)->firstOrFail();
            $filePath = storage_path('app/public/' . $attachment->file_path);
            if (!file_exists($filePath)) {
                abort(404, 'File lampiran tidak ditemukan.');
            }
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $attachment->file_name . '"'
            ]);
        }

        // Handle primary document stream
        if ($request->has('stream')) {
            $filePath = storage_path('app/public/' . $document->file_path);
            if (!file_exists($filePath)) {
                abort(404, 'File tidak ditemukan.');
            }
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $document->file_name . '"'
            ]);
        }

        return view('public.preview', compact('document'));
    }
}
