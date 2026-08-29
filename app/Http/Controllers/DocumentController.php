<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['preview']);
    }


    // public function search(Request $request)
    // {
    //     $q = $request->q;

    //     $documents = Document::query()
    //         ->when($q, function ($query) use ($q) {
    //             $query->where('title', 'like', "%$q%")
    //                 ->orWhere('nomor_surat', 'like', "%$q%") // ✅ Updated
    //                 ->orWhere('perihal', 'like', "%$q%");
    //         })
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(20);

    //     return view('documents.search', compact('documents', 'q'));
    // }

    public function search(Request $request)
    {
        $q = $request->q;
        $category = $request->category;

        $categories = Category::orderBy('name')->get();

        $documents = Document::query()
            ->when($q, function ($query) use ($q) {
                $query->where('title', 'like', "%$q%")
                    ->orWhere('nomor_surat', 'like', "%$q%")
                    ->orWhere('perihal', 'like', "%$q%");
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString(); // supaya pagination ikut filter

        return view('documents.search', compact('documents', 'q', 'categories', 'category'));
    }


    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240',
            'tanggal_surat' => 'nullable|date',
        ]);

        $file = $request->file('file');
        $name = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $name, 'public');
        $tags = array_map('trim', explode(',', $request->tags));

        Document::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'tanggal_surat' => $request->tanggal_surat,
            'tags' => $tags, // Laravel akan otomatis simpan sebagai JSON array
            'file_name' => $name,
            'file_path' => $path,
            'uploaded_by' => Auth::id(),
        ]);


        return redirect()->route('documents.search')->with('success', 'Dokumen berhasil disimpan');
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function preview(Document $document)
    {
        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return view('documents.preview', compact('document'));
    }

    public function edit($id)
    {
        $document = Document::findOrFail($id);
        $categories = Category::all();

        return view('documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'nomor_surat' => 'nullable|string',
            'perihal' => 'nullable|string',
            'category_id' => 'nullable|integer',
            'tanggal_surat' => 'nullable|date',
            'tags' => 'nullable|string', // comma separated
        ]);

        $document = Document::findOrFail($id);

        $document->update([
            'title' => $request->title,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'category_id' => $request->category_id,
            'tanggal_surat' => $request->tanggal_surat,
            'tags' => $request->tags ? explode(',', $request->tags) : [],
        ]);

        return redirect()->route('documents.search')->with('success', 'Dokumen berhasil diperbarui.');
    }
}
