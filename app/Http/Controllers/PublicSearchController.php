<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class PublicSearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->q);

        $documents = [];

        if ($q) {
            $documents = Document::where('is_public', true)
                ->where(function ($query) use ($q) {
                    $query->where('title', 'like', "%$q%")
                        ->orWhere('perihal', 'like', "%$q%")
                        ->orWhere('nomor_surat', 'like', "%$q%");
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('public.search', compact('q', 'documents'));
    }

    public function preview(Document $document)
    {
        if (!$document->is_public && !auth()->check()) {
            abort(403, 'Dokumen ini bersifat privat dan memerlukan login untuk diakses.');
        }

        return view('public.preview', compact('document'));
    }
}
