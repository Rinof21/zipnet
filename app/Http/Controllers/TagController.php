<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Tampilkan semua dokumen yang memiliki tag tertentu.
     */
    public function show($tag)
    {
        $decodedTag = urldecode($tag);

        try {
            // Coba ambil dokumen dengan kolom JSON
            $documents = Document::whereJsonContains('tags', $decodedTag)
                ->orderByDesc('created_at')
                ->paginate(20);
        } catch (\Exception $e) {
            // Jika kolom bukan JSON (misalnya string biasa), fallback ke LIKE
            $documents = Document::where('tags', 'like', "%{$decodedTag}%")
                ->orderByDesc('created_at')
                ->paginate(20);
        }

        // Kirim ke view
        return view('tags.show', compact('tag', 'documents'));
    }

    // public function show($tag)
    // {
    //     $decodedTag = urldecode($tag);

    //     $documents = Document::whereJsonContains('tags', $decodedTag)
    //         ->orderByDesc('created_at')
    //         ->paginate(20);

    //     return view('tags.show', [
    //         'tag' => $decodedTag,
    //         'documents' => $documents,
    //     ]);
    // }
}
